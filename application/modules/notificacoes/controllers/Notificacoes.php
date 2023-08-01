<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notificacoes extends MY_Controller {

    public function __construct(){
        parent::__construct();
        isLogged();
        CheckSystemMaintenance();
    }

	public function index(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = $this->lang->line('not_titulo');

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js'
        );

        $this->NotificacoesModel->MarcarComoLida();

        $data['notificacoes'] = $this->NotificacoesModel->TodasNotificacoes();

		$this->template->load('cliente/template', 'notificacoes', $data);
    }
}
