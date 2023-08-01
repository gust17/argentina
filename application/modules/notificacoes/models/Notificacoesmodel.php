<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notificacoesmodel extends CI_Model {

    public function __construct(){
        parent::__construct();

        $this->userid = $this->session->userdata('myuserid');
    }

    public function TodasNotificacoes(){

        $this->db->order_by('data_criacao', 'DESC');
        $this->db->where('id_usuario', $this->userid);
        $query = $this->db->get('notificacoes');

        if($query->num_rows() > 0){
            
            return $query->result();
        }

        return false;
    }

    public function TotalNotificacoes(){

        $this->db->where('id_usuario', $this->userid);
        $this->db->where('visualizado', 0);
        $query = $this->db->get('notificacoes');

        return $query->num_rows();
    }

    public function MarcarComoLida(){

        $this->db->where('id_usuario', $this->userid);
        $this->db->where('visualizado', 0);
        $this->db->update('notificacoes', array(
            'visualizado'=>1
        ));
    }
}
