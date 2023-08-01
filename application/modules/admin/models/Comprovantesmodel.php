<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Comprovantesmodel extends CI_Model
{

    public $userid;
    public $rotas;

    public function __construct()
    {
        parent::__construct();

        $this->userid = $this->session->userdata('admin_myuserid_92310');

        $this->rotas = MinhasRotas();
    }

    public function TodosComprovantes($status = false)
    {

        $this->db->select('c.*, u.nome, u.login, p.nome AS nome_plano, f.valor');
        $this->db->from('faturas_comprovantes AS c');
        $this->db->join('usuarios_cadastros AS u', 'u.id = c.id_usuario', 'inner');
        $this->db->join('faturas AS f', 'f.id = c.id_fatura', 'inner');
        $this->db->join('planos AS p', 'p.id = f.id_plano', 'inner');
        $this->db->where('u.data_exclusao IS NULL', null, false);
        $this->db->where('c.data_exclusao IS NULL', null, false);
        if ($status !== false) {
            $this->db->where('c.status', $status);
        }
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            return $query->result();
        }

        return false;
    }

    public function ExcluirComprovante($id)
    {

        $this->db->where('id', $id);
        $this->db->where('data_exclusao IS NULL', null, false);
        $this->db->update('faturas_comprovantes', array('data_exclusao' => date('Y-m-d H:i:s')));
        // $this->db->delete('faturas_comprovantes');

        CreateLog($this->userid, 'Excluiu o comprovante ID #' . $id, true);

        $this->session->set_flashdata('comprovantes_message', alerts('Fatura excluída com sucesso!', 'success'));

        redirect($this->rotas->admin_comprovantes_todos);
    }

    public function AprovarComprovante($id)
    {

        $this->db->where('id', $id);
        $this->db->where('data_exclusao IS NULL', null, false);
        $query = $this->db->get('faturas_comprovantes');

        if ($query->num_rows() > 0) {

            $row = $query->row();

            $active = $this->SystemModel->AtivarFatura($row->id_fatura, BancoID($row->banco), 'Fatura ativada pelo administrador: ' . UserInfo('login', $this->userid) . '. Comprovante Relacionado: ID #' . $id, false, 2);

            if ($active) {

                $celular = UserInfo('celular', $row->id_usuario);

                $this->db->where('id', $id);
                $this->db->where('data_exclusao IS NULL', null, false);
                $this->db->update('faturas_comprovantes', array('status' => 1));

                $this->session->set_flashdata('comprovantes_message', alerts('Comprovante aprovado e fatura ativada com sucesso!', 'success'));

                CreateLog($this->userid, 'Aprovou o comprovante #' . $id . ' e ativou a fatura #' . $row->id_fatura, true);
            } else {
                $this->session->set_flashdata('comprovantes_message', alerts('Erro ao tentar ativar a fatura. Tente novamente.', 'danger'));

                CreateLog($this->userid, 'Tentou aprovar o comprovante ID #' . $id . ' mas não foi possível devido a erro no módulo de ativação de faturas', true);
            }
        } else {

            $this->session->set_flashdata('comprovantes_message', alerts('Não foi possível encontrar o comprovante informado. Por favor, tente novamente.', 'danger'));
        }

        redirect($this->rotas->admin_comprovantes_todos);
    }

    public function RejeitarComprovante($id)
    {

        $motivo = $this->input->get('motivo');
        $motivo = urldecode($motivo);

        $this->db->where('id', $id);
        $this->db->where('data_exclusao IS NULL', null, false);
        $query = $this->db->get('faturas_comprovantes');

        if ($query->num_rows() > 0) {

            $row = $query->row();

            $this->db->where('id', $id);
            $this->db->update('faturas_comprovantes', array('status' => 2));

            CreateLog($this->userid, 'Rejeitou o comprovante ID #' . $id . '. Motivo: ' . $motivo, true);

            CreateNotification($row->id_usuario, 'O comprovante da sua fatura ID #' . $row->id_fatura . ' foi rejeitado. Motivo: ' . $motivo);

            $this->session->set_flashdata('comprovantes_message', alerts('Comprovante Rejeitado com sucesso!', 'success'));
        }

        redirect($this->rotas->admin_comprovantes_todos);
    }
}
