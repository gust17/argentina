<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Planosmodel extends CI_Model {

    protected $rotas;

    public function __construct(){
        parent::__construct();

        $this->userid = $this->session->userdata('myuserid');

        $this->rotas = MinhasRotas();
    }

    public function TodosPlanos($level = 1){

        $this->db->order_by('valor', 'ASC');
        $this->db->where('exibir', 1);
        $this->db->where('level', $level);
        $query = $this->db->get('planos');

        if($query->num_rows() > 0){

            return $query->result();
        }

        return false;
    }

    public function quantidadePlanosAtivos(){

        $this->db->where('id_usuario', $this->userid);
        $this->db->where('status', 1);
        $query = $this->db->get('faturas');

        return $query->num_rows();
    }

    public function ListarPlanos($status = 1){

        $this->db->select('f.*, p.nome');
        $this->db->from('faturas AS f');
        $this->db->join('planos AS p', 'p.id = f.id_plano', 'inner');
        $this->db->where('f.status', $status);
        $this->db->where('f.id_usuario', $this->userid);
        $query = $this->db->get();

        if($query->num_rows() > 0){

            return $query->result();
        }

        return false;
    }

    public function GerarFatura(){

        $id_plano = $this->input->post('id_plano');

        $quantidadePermitida = PlanInfo($id_plano, 'compras_simultaneas');
        $percentualPago = PlanInfo($id_plano, 'percentual_pago');
        $scoreNecessario = PlanInfo($id_plano, 'score_necessario');
        $quantidadeTotalPlanos = SystemInfo('quantidade_planos');

        if(UserInfo('score') < $scoreNecessario){

            return alerts($this->lang->line('plan_m_score_necessario'), 'danger');
        }

        if($quantidadePermitida !== false){

            $this->db->where('id_usuario', $this->userid);
            $this->db->group_start();
            $this->db->where('status', 1);
            $this->db->or_where('status', 0);
            $this->db->group_end();
            $queryInvoiceListAll = $this->db->get('faturas');

            if($queryInvoiceListAll->num_rows() >= $quantidadeTotalPlanos){

                return alerts($this->lang->line('plan_m_limite_faturas_excedidas'), 'danger');
            }

            $this->db->where('id_usuario', $this->userid);
            $this->db->where('id_plano', $id_plano);
            $this->db->group_start();
            $this->db->where('status', 1);
            $this->db->or_where('status', 0);
            $this->db->group_end();
            $queryInvoiceListSpecific = $this->db->get('faturas');

            if($queryInvoiceListSpecific->num_rows() >= $quantidadePermitida){

                return alerts($this->lang->line('plan_m_limite_planos_excedidos'), 'danger');
            }

            $valorPlano = PlanInfo($id_plano, 'valor');

            $this->db->insert('faturas', array(
                'id_usuario'=>$this->userid,
                'renovacao'=>0,
                'id_plano'=>$id_plano,
                'valor'=>$valorPlano,
                'percentual_pago'=>$percentualPago,
                'niveis_indicacao'=>PlanInfo($id_plano, 'niveis_indicacao'),
                'quantidade_pagamentos_fazer'=>PlanInfo($id_plano, 'quantidade_dias'),
                'status'=>0,
                'data_criacao'=>date('Y-m-d H:i:s')
            ));

            CreateLog($this->userid, 'O usuário gerou uma fatura no valor de '.MOEDA.' '.number_format($valorPlano, 2, ',', '.'));

            return alerts(
                $this->lang->line('plan_m_fatura_gerada_ok').'<meta http-equiv="refresh" content="2;url='.base_url($this->rotas->faturas_lista).'" />',
                'success'
            );
        }

        return alerts($this->lang->line('plan_m_plano_inexistente'), 'danger');
    }
}
