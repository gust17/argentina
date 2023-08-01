<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Faturasmodel extends CI_Model
{

    public $userid;
    public $rotas;

    public function __construct()
    {
        parent::__construct();

        $this->userid = $this->session->userdata('admin_myuserid_92310');

        $this->rotas = MinhasRotas();
    }

    public function EntradasTotais()
    {

        $this->db->select_sum('valor');
        $this->db->from('faturas');
        $this->db->where('status >', 0);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            return $query->row()->valor;
        }

        return 0;
    }

    public function FaturasStatus($status = 1)
    {

        $this->db->where('status', $status);
        $query = $this->db->get('faturas');

        return $query->num_rows();
    }

    public function TodasFaturas($status = false)
    {

        $this->db->select('f.*, u.nome, u.login');
        $this->db->from('faturas AS f');
        $this->db->join('usuarios_cadastros AS u', 'u.id = f.id_usuario', 'inner');
        $this->db->where('u.data_exclusao IS NULL', null, false);

        if ($status !== false) {
            $this->db->where('f.status', $status);
        }

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            return $query->result();
        }

        return false;
    }

    public function ExcluirFatura($id)
    {

        $this->db->where('id', $id);
        $this->db->update('faturas', array('data_exclusao' => date('Y-m-d H:i:s')));
        // $this->db->delete('faturas');

        CreateLog($this->userid, 'Excluiu a fatura #' . $id, true);

        $this->session->set_flashdata('faturas_message', alerts('Fatura excluída com sucesso!', 'success'));

        redirect($this->rotas->admin_faturas_todas);
    }

    public function AtivarFatura($id)
    {

        $this->db->where('id', $id);
        $this->db->where('status', 0);
        $this->db->where('data_exclusao IS NULL', null, false);
        $query = $this->db->get('faturas');

        if ($query->num_rows() > 0) {

            $active = $this->SystemModel->AtivarFatura($id, 'DIRETO', 'Ativado pelo administrador: ' . UserInfo('login', $this->userid), false, 2);

            if ($active) {

                CreateLog($this->userid, 'Ativou a fatura #' . $id, true);

                $this->session->set_flashdata('faturas_message', alerts('Fatura ativada com sucesso!', 'success'));
            } else {
                $this->session->set_flashdata('faturas_message', alerts('Erro ao ativar a fatura. Tente novamente ou fale com o programador', 'danger'));
            }
        } else {

            $this->session->set_flashdata('faturas_message', alerts('A fatura que você está tentando ativar não existe ou já está ativa', 'danger'));
        }

        redirect($this->rotas->admin_faturas_todas);
    }

    public function AtivarFaturaCortesia($id)
    {

        $this->db->where('id', $id);
        $this->db->where('status', 0);
        $this->db->where('data_exclusao IS NULL', null, false);
        $query = $this->db->get('faturas');

        if ($query->num_rows() > 0) {

            $active = $this->SystemModel->AtivarFatura($id, SystemInfo('faturas_cortesia_label'), 'Ativado como cortesia pelo administrador: ' . UserInfo('login', $this->userid), true);

            if ($active) {

                CreateLog($this->userid, 'Ativou a fatura #' . $id . ' como cortesia', true);

                $this->session->set_flashdata('faturas_message', alerts('Fatura cortesia ativada com sucesso!', 'success'));
            } else {
                $this->session->set_flashdata('faturas_message', alerts('Erro ao ativar a fatura cortesia. Tente novamente ou fale com o programador', 'danger'));
            }
        } else {

            $this->session->set_flashdata('faturas_message', alerts('A fatura cortesia que você está tentando ativar não existe ou já está ativa', 'danger'));
        }

        redirect($this->rotas->admin_faturas_todas);
    }
}
