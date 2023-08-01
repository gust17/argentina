<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarefas extends MY_Controller {

    public function __construct(){
        parent::__construct();
        isLogged();
        CheckSystemMaintenance();

        $this->load->model('tarefasmodel', 'TarefasModel');
    }

	public function index(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = 'Tarefas';

        $data['jsLoader'] = array(
            
        );

        if($this->input->post('submit')){
            $data['message'] = $this->TarefasModel->EnviarTarefa();
        }

        $data['tarefas'] = $this->TarefasModel->TodasTarefas();
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();

		$this->template->load('cliente/template', 'tarefas', $data);
    }
}
