<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesquisasmodel extends CI_Model {

    protected $dados;
    protected $retorno;
    protected $rotas;

    public function __construct(){
        parent::__construct();

        $this->rotas = MinhasRotas();

        $this->userid = $this->session->userdata('admin_myuserid_92310');
    }

    public function PesquisasSatisfacao(){

        $this->db->select('p.*, u.login');
        $this->db->from('pesquisas_satisfacao AS p');
        $this->db->join('usuarios_cadastros AS u', 'u.id = p.id_usuario', 'inner');
        $query = $this->db->get();

        if($query->num_rows() > 0){

            return $query->result();
        }

        return false;
    }

    public function PesquisasPatrocinador(){

        $this->db->select('p.*, u.login');
        $this->db->from('pesquisas_patrocinador AS p');
        $this->db->join('usuarios_cadastros AS u', 'u.id = p.id_patrocinador', 'inner');
        $query = $this->db->get();

        if($query->num_rows() > 0){

            return $query->result();
        }

        return false;
    }
}