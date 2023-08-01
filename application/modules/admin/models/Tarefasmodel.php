<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tarefasmodel extends CI_Model
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

    public function InfoTarefa($id)
    {

        $this->db->select('tp.*, t.recompensa, t.tarefa');
        $this->db->from('tarefas_prints AS tp');
        $this->db->join('tarefas AS t', 't.id = tp.id_tarefa');
        $this->db->where('tp.id', $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function TodasTarefas($status)
    {

        $this->db->select('tp.*, t.recompensa, t.tarefa');
        $this->db->from('tarefas_prints AS tp');
        $this->db->join('tarefas AS t', 't.id = tp.id_tarefa');
        $this->db->where('tp.status', $status);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            return $query->result();
        }

        return false;
    }

    public function Aprovar($id)
    {


        $tarefa = $this->InfoTarefa($id);

        $scoreAtual = UserInfo('score', $tarefa->id_usuario);

        $this->db->where('id', $id);
        $this->db->update('tarefas_prints', array(
            'status' => 1,
            'data_atualizacao' => date('Y-m-d H:i:s')
        ));

        $this->db->where('id', $tarefa->id_usuario);
        $this->db->update('usuarios_cadastros', array(
            'score' => ($scoreAtual + $tarefa->recompensa)
        ));

        CreateNotification($tarefa->id_usuario, 'O print da tarefa "<b>' . $tarefa->tarefa . '</b>" foi aprovado com sucesso.');

        $this->session->set_flashdata('tarefas_messages', alerts('Tarefa aprovada com sucesso!', 'success'));

        redirect(base_url($this->rotas->admin_tarefas_todas));
    }

    public function Rejeitar($id)
    {

        $tarefa = $this->InfoTarefa($id);

        $motivo = $this->input->get('motivo');
        $motivo = urldecode($motivo);

        $this->db->where('id', $id);
        $this->db->update('tarefas_prints', array(
            'status' => 2,
            'data_atualizacao' => date('Y-m-d H:i:s')
        ));

        CreateNotification($tarefa->id_usuario, 'Infelizmente o print da sua tarefa "<b>' . $tarefa->tarefa . '</b>" Não pode ser aprovada, motivo: ' . $motivo);

        $this->session->set_flashdata('tarefas_messages', alerts('Print da tarefa rejeitada com sucesso!', 'success'));

        redirect(base_url($this->rotas->admin_tarefas_todas));
    }
}
