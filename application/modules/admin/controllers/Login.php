<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

    public function __construct(){
        parent::__construct();

        $this->load->model('loginmodel', 'LoginModel');
    }

	// public function index(){

    //     CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

    //     $data = [];

    //     if($this->input->post('submit')){
    //         $data['message'] = $this->LoginModel->FazerLogin();
    //     }

	// 	$this->load->view('login', $data);
    // }

    public function entrar_admin(){

        if($this->input->post('submitAdmin')){
            $data['message'] = $this->LoginModel->FazerLogin();
        }
    }
}
