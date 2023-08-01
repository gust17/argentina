<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends MY_Controller {

    public function __construct(){
        parent::__construct();

        isLoggedAdmin();
        EnabledMasterKey(true);

        $this->permission->AuthorizationWithRedirect('logs');
        
        $this->load->model('logsmodel', 'LogsModel');
    }

	public function index(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $data['nome_pagina'] = 'Lista de logs no administrador';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js'
        );

        $data['logs'] = $this->LogsModel->TodosLogs();

		$this->template->load('admin/template', 'logs/logs', $data);
    }
}
