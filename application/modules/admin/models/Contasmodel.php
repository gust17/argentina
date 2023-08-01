<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contasmodel extends CI_Model {

    protected $rotas;
    protected $userid;

    public function __construct(){
        parent::__construct();

        $this->rotas = MinhasRotas();

        $this->userid = $this->session->userdata('admin_myuserid_92310');
    }

    public function TodasContas(){

       $query = $this->db->get('configuracoes_contas_bancarias');

       if($query->num_rows() > 0){

            return $query->result();
       }

       return false;
    }

    public function InformacoesConta($id){

        $this->db->where('id', $id);
        $query = $this->db->get('configuracoes_contas_bancarias');
 
        if($query->num_rows() > 0){
 
             return $query->row();
        }
 
        return false;
     }

    public function AdicionarConta(){

        $banco = $this->input->post('banco', true);
        $agencia = $this->input->post('agencia', true);
        $conta = $this->input->post('conta');
        $conta_tipo = $this->input->post('conta_tipo', true);
        $titular = $this->input->post('titular', true);
        $documento = $this->input->post('documento', true);

        $this->db->insert('configuracoes_contas_bancarias', array(
            'banco'=>$banco,
            'agencia'=>$agencia,
            'conta'=>$conta,
            'conta_tipo'=>$conta_tipo,
            'titular'=>$titular,
            'documento'=>$documento,
        ));

        $insert = $this->db->insert_id();

        if($insert > 0){

            CreateLog($this->userid, 'Cadastrou a conta bancária ID #'.$insert, true);

            return alerts('Conta Bancária cadastrada com sucesso!', 'success');
        }
        
        return alerts('Erro ao cadastrar a conta bancária, tente novamente', 'danger');
    }

    public function EditarConta($id){

        $banco = $this->input->post('banco', true);
        $agencia = $this->input->post('agencia', true);
        $conta = $this->input->post('conta');
        $conta_tipo = $this->input->post('conta_tipo', true);
        $titular = $this->input->post('titular', true);
        $documento = $this->input->post('documento', true);

        $this->db->where('id', $id);
        $update = $this->db->update('configuracoes_contas_bancarias', array(
            'banco'=>$banco,
            'agencia'=>$agencia,
            'conta'=>$conta,
            'conta_tipo'=>$conta_tipo,
            'titular'=>$titular,
            'documento'=>$documento,
        ));

        if($update){

            CreateLog($this->userid, 'Atualizou a conta bancária ID #'.$id, true);

            return alerts('Conta Bancária atualizada com sucesso!', 'success');
        }
        
        return alerts('Erro ao atualizar a conta bancária, tente novamente', 'danger');
    }

    public function ExcluirConta($id){

        $this->db->where('id', $id);
        $this->db->delete('configuracoes_contas_bancarias');

        $this->session->set_flashdata('contas_message', alerts('Conta Bancária excluída com sucesso!', 'success'));

        CreateLog($this->userid, 'Excluiu a conta bancária ID #'.$id, true);

        redirect($this->rotas->admin_contas_todas);
    }
}