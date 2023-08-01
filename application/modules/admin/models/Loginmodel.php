<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Authy\AuthyApi;

class Loginmodel extends CI_Model {

    protected $GoogleAuthenticator;

    public function __construct(){
        parent::__construct();

        $this->userid = $this->session->userdata('myuserid');
    }

    public function FazerLogin(){

        $rotas = MinhasRotas();

        $this->db->where('id', $this->userid);
        $this->db->where('data_exclusao IS NULL', null, false);
        $queryLogin = $this->db->get('usuarios_cadastros');

        if($queryLogin->num_rows() > 0){

            $row = $queryLogin->row();

            if($row->is_admin == 1){

                CreateLog($row->id, 'Acessou o painel administrativo c/ acesso total', true);

                $this->session->set_userdata('mkey_accept_login_admin', true);
                $this->session->set_userdata('admin_myuserid_92310', $this->userid);

                redirect($rotas->admin_dashboard);

                
                exit;
            }else{

                redirect($rotas->backoffice);
                exit;
            }
        }
    }

    // public function FazerLogin(){

    //     $rotas = MinhasRotas();

    //     $login = $this->input->post('login', true);
    //     $senha = $this->input->post('senha', true);
    //     $masterkey = $this->input->post('masterkey', true);

    //     $authyCode = $this->input->post('authy', true);
    //     $authyCode = str_replace(' ', '', $authyCode);

    //     $masterkeyAccepted = false;

    //     $this->db->where('login', $login);
    //     $this->db->where('data_exclusao IS NULL', null, false);
    //     $queryLogin = $this->db->get('usuarios_cadastros');

    //     if($queryLogin->num_rows() > 0){

    //         $row = $queryLogin->row();

    //         if(password_verify($senha, $row->senha)){

    //             if($row->is_admin == 1){

    //                 if(SystemInfo('authy_habilitar') == 1){

    //                     $api = new AuthyApi(SystemInfo('authy_token'), 'https://api.authy.com');

    //                     $verify = $api->verifyToken($row->admin_authy_code, $authyCode);

    //                     if($verify->ok() !== true){

    //                         return alerts('Código Authy inválido. Digite-o novamente.', 'danger');
    //                     }

    //                 }

    //                 if(!empty($masterkey)){

    //                     if($masterkey != $this->config->item('master_key')){

    //                         return alerts('A <b>Masterkey</b> informada está incorreta. Tente novamente ou entre com acesso limitado ao admin sem informar a masterkey.', 'danger');
    //                     }

    //                     CreateLog($row->id, 'Acessou o painel administrativo c/ acesso da masterkey', true);
    //                     $masterkeyAccepted = true;
    //                 }

    //                 if($masterkeyAccepted){

    //                     $this->session->set_userdata('mkey_accept_login_admin', true);

    //                 }else{

    //                     $this->session->set_userdata('mkey_accept_login_admin', false);

    //                     CreateLog($row->id, 'Acessou o painel administrativo s/ acesso da masterkey', true);
    //                 }

    //                 $this->session->set_userdata('admin_myuserid_92310', $row->id);

    //                 redirect($rotas->admin_dashboard);

                    
    //                 exit;
    //             }

    //             CreateLog($row->id, 'O usuário tentou acessar o admin, mas ele não é admin');
    //             CreateLog($row->id, '<span class="text-danger">Tentou acessar o admin, mas ele não tem permissão.</span>', true);

    //             return alerts('O usuário informado não é administrador. Por favor, entre com um usuário administrativo.', 'danger');
    //         }

    //         CreateLog($row->id, 'O usuário tentou acessar o admin, mas informou a senha inválida.');

    //         return alerts('A senha informada não está correta, por favor, verifique.', 'danger');
    //     }

    //     return alerts('Login não cadastrado em nosso banco de dados.', 'danger');
    // }
}