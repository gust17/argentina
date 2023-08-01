<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rotas extends MY_Controller {

    public function __construct(){
        parent::__construct();

        isLoggedAdmin();
        EnabledMasterKey(true);

        $this->permission->AuthorizationWithRedirect('configuracoes.rotas');
        
        $this->load->model('rotasmodel', 'RotasModel');
    }

	public function index(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $data['nome_pagina'] = 'Lista de Rotas';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js'
        );

        $data['routes'] = $this->RotasModel->TodasRotas();

		$this->template->load('admin/template', 'rotas/rotas', $data);
    }

    public function editar($id){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $data['nome_pagina'] = 'Editar Rota';

        $data['rotas'] = MinhasRotas();

        if($this->input->post('submit')){
            $data['message'] = $this->RotasModel->EditarRota($id);
        }

        $data['route'] = $this->RotasModel->InformacoesRota($id);

		$this->template->load('admin/template', 'rotas/editar', $data);
    }
}
