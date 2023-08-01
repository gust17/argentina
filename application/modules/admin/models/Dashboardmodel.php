<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboardmodel extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function Deslogar(){

        $this->session->unset_userdata('admin_myuserid_92310');
        $this->session->unset_userdata('mkey_accept_login_admin');

        redirect(MinhasRotas('SPEC', 'backoffice'));
    }
}