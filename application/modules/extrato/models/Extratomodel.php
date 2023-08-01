<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Extratomodel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

        $this->userid = $this->session->userdata('myuserid');
    }

    public function ultimasMovimentacoes($quantidade)
    {

        $this->db->limit($quantidade);
        $this->db->order_by('data_criacao', 'DESC');
        $this->db->where('id_usuario', $this->userid);
        $query = $this->db->get('extrato');

        if ($query->num_rows() > 0) {

            return $query->result();
        }

        return false;
    }

    public function MeuExtrato($categoria = null)
    {
        if (!is_null($categoria)) {
            $this->db->where('categoria', $categoria);
        }

        $this->db->where('id_usuario', $this->userid);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('extrato');

        if ($query->num_rows() > 0) {

            return $query->result();
        }

        return false;
    }
}
