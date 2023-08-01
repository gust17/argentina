<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pacotesmodel extends CI_Model {

    protected $rotas;
    protected $userid;

    public function __construct(){
        parent::__construct();

        $this->rotas = MinhasRotas();

        $this->userid = $this->userid = $this->session->userdata('admin_myuserid_92310');
    }

    public function TodosPacotes(){

       $query = $this->db->get('planos');

       if($query->num_rows() > 0){

            return $query->result();
       }

       return false;
    }

    public function InformacoesPacote($id){

        $this->db->where('id', $id);
        $query = $this->db->get('planos');
 
        if($query->num_rows() > 0){
 
             return $query->row();
        }
 
        return false;
     }

    public function AdicionarPacote(){

        $arrNiveis = [];

        $nome = $this->input->post('nome', true);
        $valor = $this->input->post('valor', true);
        $niveis = $this->input->post('niveis');
        $pontos = $this->input->post('pontos', true);
        $dia_util = $this->input->post('dia_util', true);
        $dias = $this->input->post('dias', true);
        $percentual = $this->input->post('percentual', true);
        $compras = $this->input->post('compras', true);
        $exibir = $this->input->post('exibir', true);
        $score_necessario = $this->input->post('score_necessario', true);
        $score_ganho = $this->input->post('score_ganho', true);

        if(!empty($niveis)){

            foreach($niveis as $nivel=>$nivelPercentual){

                if(!empty($nivelPercentual)){

                    $arrNiveis[$nivel] = trim($nivelPercentual);
                }
            }
        }

        $this->db->insert('planos', array(
            'nome'=>$nome,
            'valor'=>$valor,
            'niveis_indicacao'=>json_encode($arrNiveis),
            'pontos'=>(!empty($pontos)) ? $pontos : 0,
            'dia_util'=>$dia_util,
            'quantidade_dias'=>$dias,
            'percentual_pago'=>$percentual,
            'compras_simultaneas'=>$compras,
            'exibir'=>$exibir,
            'score_necessario'=>$score_necessario,
            'score_ganho'=>$score_ganho
        ));

        $insert = $this->db->insert_id();

        if($insert > 0){

            CreateLog($this->userid, 'Criou o plano ID #'.$insert, true);

            return alerts('Plano criado com sucesso!', 'success');
        }
        
        return alerts('Erro ao criar plano, tente novamente', 'danger');
    }

    public function EditarPacote($id){

        $arrNiveis = [];

        $nome = $this->input->post('nome', true);
        $valor = $this->input->post('valor', true);
        $niveis = $this->input->post('niveis');
        $pontos = $this->input->post('pontos', true);
        $dia_util = $this->input->post('dia_util', true);
        $dias = $this->input->post('dias', true);
        $percentual = $this->input->post('percentual', true);
        $compras = $this->input->post('compras', true);
        $exibir = $this->input->post('exibir', true);
        $score_necessario = $this->input->post('score_necessario', true);
        $score_ganho = $this->input->post('score_ganho', true);

        if(!empty($niveis)){

            foreach($niveis as $nivel=>$nivelPercentual){

                if(!empty($nivelPercentual)){

                    $arrNiveis[$nivel] = trim($nivelPercentual);
                }
            }
        }

        $this->db->where('id', $id);
        $update = $this->db->update('planos', array(
            'nome'=>$nome,
            'valor'=>$valor,
            'niveis_indicacao'=>json_encode($arrNiveis),
            'pontos'=>(!empty($pontos)) ? $pontos : 0,
            'dia_util'=>$dia_util,
            'quantidade_dias'=>$dias,
            'percentual_pago'=>$percentual,
            'compras_simultaneas'=>$compras,
            'exibir'=>$exibir,
            'score_necessario'=>$score_necessario,
            'score_ganho'=>$score_ganho
        ));

        if($update){

            CreateLog($this->userid, 'Atualizou o plano ID #'.$id, true);

            return alerts('Plano atualizado com sucesso!', 'success');
        }
        
        return alerts('Erro ao atualizar plano, tente novamente', 'danger');
    }

    public function ExcluirPacote($id){

        $this->db->where('id', $id);
        $this->db->delete('planos');

        $this->session->set_flashdata('pacotes_message', alerts('Pacote excluído com sucesso!', 'success'));

        CreateLog($this->userid, 'Excluiu o plano ID #'.$id, true);

        redirect($this->rotas->admin_pacotes_todos);
    }
}