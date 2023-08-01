<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logsmodel extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function TodosLogs($limit = false){

        $this->db->select('l.*, u.nome, u.login');
        $this->db->from('admin_logs AS l');
        $this->db->join('usuarios_cadastros AS u', 'u.id = l.id_usuario', 'inner');
        $this->db->where('u.data_exclusao IS NULL', null, false);
        $this->db->order_by('l.data_criacao', 'DESC');

        if($limit){
            $this->db->limit($limit);
        }

        $query = $this->db->get();

        if($query->num_rows() > 0){

            return $query->result();
        }

        return false;
    }
}