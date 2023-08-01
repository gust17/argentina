<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Validacaomodel extends CI_Model
{

    protected $dados;
    protected $retorno;
    protected $rotas;

    public function __construct()
    {
        parent::__construct();

        $this->rotas = MinhasRotas();

        $this->userid = $this->session->userdata('admin_myuserid_92310');
    }

    public function InfoDocumento($id)
    {

        $this->db->where('id', $id);
        $query = $this->db->get('usuarios_validacoes');

        return $query->row();
    }

    public function Documentos($status)
    {

        $this->db->where('status', $status);
        $query = $this->db->get('usuarios_validacoes');

        if ($query->num_rows() > 0) {

            return $query->result();
        }

        return false;
    }

    public function Aprovar($id)
    {

        $validacao = $this->InfoDocumento($id);

        $this->db->where('id', $id);
        $this->db->update('usuarios_validacoes', array(
            'status' => 1,
            'data_atualizacao' => date('Y-m-d H:i:s')
        ));

        $this->db->where('id', $validacao->id_usuario);
        $this->db->update('usuarios_cadastros', array(
            'cadastro_validado' => 1
        ));

        CreateNotification($validacao->id_usuario, 'Parabéns, seu cadastro foi validado com sucesso!!!');

        $this->session->set_flashdata('documentos_messages', alerts('Documentos aprovados com sucesso!', 'success'));

        redirect(base_url($this->rotas->validacao_todos));
    }

    public function Rejeitar($id)
    {

        $validacao = $this->InfoDocumento($id);

        $motivo = $this->input->get('motivo');
        $motivo = urldecode($motivo);

        $this->db->where('id', $id);
        $this->db->update('usuarios_validacoes', array(
            'status' => 2,
            'status_motivo' => $motivo,
            'data_atualizacao' => date('Y-m-d H:i:s')
        ));

        CreateNotification($validacao->id_usuario, 'Infelizmente seu cadastro não foi validado, motivo: ' . $motivo);

        $this->session->set_flashdata('documentos_messages', alerts('Documentos rejeitados com sucesso!', 'success'));

        redirect(base_url($this->rotas->validacao_todos));
    }
}
