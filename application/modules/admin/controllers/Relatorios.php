<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorios extends MY_Controller {

    public function __construct(){
        parent::__construct();

        isLoggedAdmin();
        EnabledMasterKey(true);

        $this->permission->AuthorizationWithRedirect('relatorios');
        
        // $this->load->model('relatoriosmodel', 'RelatoriosModel');
    }

	public function index(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $data['nome_pagina'] = 'Relatório Geral';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            
        );

        $data['jsLoader'] = array(
            'assets/admin/assets/libs/apexcharts/apexcharts.min.js',
            'assets/admin/assets/js/pages/relatorios.js'
        );

        // $data['contas'] = $this->RelatoriosModel->TodasContas();

		$this->template->load('admin/template', 'relatorios/relatorios', $data);
    }
}
