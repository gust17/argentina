<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesquisas extends MY_Controller {

    public function __construct(){
        parent::__construct();
        
        isLoggedAdmin();

        $this->permission->AuthorizationWithRedirect('pesquisas');
        
        $this->load->model('pesquisasmodel', 'PesquisasModel');
    }

	public function satisfacao(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('pesquisas.satisfacao');

        $data['nome_pagina'] = 'Pesquisas de Satisfação';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js',
        );
        
        $data['pesquisas'] = $this->PesquisasModel->PesquisasSatisfacao();

		$this->template->load('admin/template', 'pesquisas/satisfacao', $data);
    }

    public function patrocinador(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('pesquisas.patrocinador');

        $data['nome_pagina'] = 'Pesquisas de Patrocinador';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js',
        );
        
        $data['pesquisas'] = $this->PesquisasModel->PesquisasPatrocinador();

		$this->template->load('admin/template', 'pesquisas/patrocinador', $data);
    }
}
