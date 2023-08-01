<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Caixamodel extends CI_Model
{

    public $userid;
    public $rotas;

    public function __construct()
    {
        parent::__construct();

        $this->userid = $this->session->userdata('admin_myuserid_92310');

        $this->rotas = MinhasRotas();
    }

    public function TodosRegistros()
    {

        $query = $this->db->get('caixa');

        if ($query->num_rows() > 0) {

            return $query->result();
        }

        return false;
    }

    public function AdicionarRegistro()
    {

        $descricao = trim($this->input->post('descricao', true));
        $valor = $this->input->post('valor', true);
        $tipo = $this->input->post('tipo', true);

        if (empty($descricao) || empty($valor)) {

            return alerts('Preencha todos os campos para continuar', 'danger');
        }

        $this->db->insert('caixa', array(
            'id_usuario_admin' => $this->userid,
            'registro' => $descricao,
            'tipo' => $tipo,
            'valor' => $valor,
            'ip' => $this->input->ip_address(),
            'data_criacao' => date('Y-m-d H:i:s')
        ));

        $id = $this->db->insert_id();

        $this->session->set_flashdata('caixa_message', alerts('Registro criado com sucesso', 'success'));

        CreateLog($this->userid, 'Criou o registro #' . $id . ' no caixa da empresa', true);

        redirect($this->rotas->admin_caixa);
    }

    public function EntradasTotais()
    {

        $query = $this->db->query('SELECT COALESCE(SUM(valor), 0) AS valor FROM caixa WHERE tipo = 1');

        if ($query->num_rows() > 0) {

            return $query->row()->valor;
        }

        return 0;
    }

    public function SaidasTotais($status = 2)
    {

        $query = $this->db->query('SELECT COALESCE(SUM(valor), 0) AS valor FROM caixa WHERE tipo = ' . $status);

        if ($query->num_rows() > 0) {

            return $query->row()->valor;
        }

        return 0;
    }
}
