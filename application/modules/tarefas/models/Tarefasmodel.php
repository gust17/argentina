<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tarefasmodel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

        $this->userid = $this->session->userdata('myuserid');

        $this->load->library('upload');
    }

    public function TodasTarefas()
    {

        $this->db->order_by('data_liberacao', 'DESC');
        $this->db->where('exibir', 1);
        $query = $this->db->get('tarefas');

        if ($query->num_rows() > 0) {

            return $query->result();
        }

        return false;
    }

    public function StatusEntregaTarefa($id)
    {

        $this->db->order_by('id', 'DESC');
        $this->db->where('id_tarefa', $id);
        $this->db->where('id_usuario', $this->userid);
        $query = $this->db->get('tarefas_prints');

        if ($query->num_rows() > 0) {

            $row = $query->row();

            if ($row->status == 0) {

                return 1; //Enviado e aguardando

            } elseif ($row->status == 1) {

                return 2; //Aprovado

            } else {

                return 3; //Reprovado
            }
        }

        return 0; //Não enviado
    }

    public function EnviarTarefa()
    {

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'bmp|png|jpeg|jpg|pdf';
        $config['encrypt_name'] = true;

        $id_tarefa = $this->input->post('id_tarefa');

        $this->upload->initialize($config);

        if ($this->upload->do_upload('anexo')) {

            $data = $this->upload->data();

            $login = UserInfo('login');
            $result = UploadS3($login . '/' . $data['file_name'], 'uploads/' . $data['file_name'], 'starkpix-tarefas');

            $this->db->insert('tarefas_prints', array(
                'id_usuario' => $this->userid,
                'id_tarefa' => $id_tarefa,
                'print' => $result['ObjectURL'],
                'status' => 0,
                'data_criacao' => date('Y-m-d H:i:s'),
                'data_atualizacao' => date('Y-m-d H:i:s')
            ));

            @unlink('uploads/' . $data['file_name']);

            return alerts('Print da tarefa enviada com sucesso. Nossa equipe aprovará em até 12h.', 'success');
        }

        return alerts('Ocorreu um erro ao enviar o print: ' . $this->upload->display_errors(), 'danger');
    }
}
