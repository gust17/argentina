<?php
define("RECAPTCHA_V3_SECRET_KEY", '6Ldung4eAAAAAIOcEQ2C-WziLv0HzpQUQd5RFCh6');
class Loginmodel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('throttle');
    }

    public function FazerLogin()
    {

        $this->throttle->throttle(1, 40, 60);

        $backoffice = MinhasRotas('SPEC', 'backoffice');

        $login = trim($this->input->post('login', true));
        $password = $this->input->post('senha', true);
        $redirect = $this->input->post('redirect', true);
        $token = $this->input->post('token', true);
        $action = $this->input->post('action', true);

        $responseRecaptcha = $this->recaptcha->verifyResponse($token, $action);

        // if (isset($responseRecaptcha['success']) && $responseRecaptcha['success'] === true) {

        if (true) {

            $this->db->where('login', $login);
            $this->db->where('data_exclusao IS NULL', null, false);
            $queryCheckLoginExists = $this->db->get('usuarios_cadastros');

            if ($queryCheckLoginExists->num_rows() > 0) {

                $rowLogin = $queryCheckLoginExists->row();

                if (password_verify($password, $rowLogin->senha)) {

                    if ($rowLogin->status == 1) {

                        $linguagem = $rowLogin->linguagem_padrao;

                        if (!empty($linguagem) && !is_null($linguagem)) {

                            $this->session->set_userdata('site_lang', $linguagem);
                        }

                        $this->session->set_userdata('myuserid', $rowLogin->id);

                        CreateLog(
                            $rowLogin->id,
                            'O login ' . $rowLogin->login . ' entrou no backoffice com sucesso!'
                        );

                        $this->db->where('id', $rowLogin->id);
                        $this->db->update('usuarios_cadastros', array(
                            'ultimo_ip' => $this->input->ip_address(),
                            'ultimo_login' => date('Y-m-d H:i:s')
                        ));

                        if (is_null($redirect) && empty($redirect)) {

                            redirect($backoffice);
                        } else {

                            redirect($redirect);
                        }
                    } else {

                        CreateLog(
                            $rowLogin->id,
                            'O login' . $rowLogin->login . ' tentou acessar o backoffice e não conseguiu pois recebeu a mensagem: ' . $rowLogin->status_mensagem
                        );

                        return alerts(sprintf($this->lang->line('login_m_erro_entrar_backoffice'), $rowLogin->status_mensagem), 'danger');
                    }
                }

                return alerts($this->lang->line('login_m_senha_incorreta'), 'danger');
            }

            return alerts($this->lang->line('login_m_login_invalido'), 'danger');
        }

        return alerts($this->lang->line('eu_nao_sou_robo'), 'danger');
    }
}
