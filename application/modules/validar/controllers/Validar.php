<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validar extends MY_Controller {

    public function __construct(){
        parent::__construct();
        isLogged();
        CheckSystemMaintenance();

        $this->load->model('validarmodel', 'ValidarModel');
    }

	public function index(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = $this->lang->line('validar_titulo');

        if($this->input->post('submit')){

            $data['message'] = $this->ValidarModel->EnviarDocumentos();
        }

        $data['status'] = $this->ValidarModel->StatusDocumento();

		$this->template->load('cliente/template', 'validar', $data);
    }
}
