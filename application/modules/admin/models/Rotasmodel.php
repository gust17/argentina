<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rotasmodel extends CI_Model {

    protected $rotas;
    protected $userid;

    public function __construct(){
        parent::__construct();

        $this->rotas = MinhasRotas();

        $this->userid = $this->session->userdata('admin_myuserid_92310');
    }

    public function TodasRotas(){

       $query = $this->db->get('configuracoes_rotas');

       if($query->num_rows() > 0){

            return $query->result();
       }

       return false;
    }

    public function InformacoesRota($id){

        $this->db->where('id', $id);
        $query = $this->db->get('configuracoes_rotas');
 
        if($query->num_rows() > 0){
 
             return $query->row();
        }
 
        return false;
     }

    public function EditarRota($id){

        $nome = $this->input->post('nome', true);
        $rota = $this->input->post('rota', true);

        $this->db->where('id', $id);
        $update = $this->db->update('configuracoes_rotas', array(
            'link_nome'=>$nome,
            'route'=>$rota
        ));

        if($update){

            CreateLog($this->userid, 'Atualizou a Rota <b>'.$nome.'</b>, ID #'.$id, true);

            return alerts('Rota atualizada com sucesso!', 'success');
        }
        
        return alerts('Erro ao atualizar a rota, tente novamente', 'danger');
    }
}