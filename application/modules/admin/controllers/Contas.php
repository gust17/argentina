<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contas extends MY_Controller {

    public function __construct(){
        parent::__construct();

        isLoggedAdmin();
        EnabledMasterKey(true);

        $this->permission->AuthorizationWithRedirect('configuracoes.contas_bancarias');
        
        $this->load->model('contasmodel', 'ContasModel');
    }

	public function index(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $data['nome_pagina'] = 'Lista de Contas Bancárias cadastradas';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js'
        );

        $data['contas'] = $this->ContasModel->TodasContas();

		$this->template->load('admin/template', 'contas/contas', $data);
    }

    public function nova(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $data['nome_pagina'] = 'Nova Conta Bancária';

        $data['rotas'] = MinhasRotas();

        if($this->input->post('submit')){
            $data['message'] = $this->ContasModel->AdicionarConta();
        }

		$this->template->load('admin/template', 'contas/nova', $data);
    }

    public function editar($id){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $data['nome_pagina'] = 'Editar Conta Bancária';

        $data['rotas'] = MinhasRotas();

        if($this->input->post('submit')){
            $data['message'] = $this->ContasModel->EditarConta($id);
        }

        $data['conta'] = $this->ContasModel->InformacoesConta($id);

		$this->template->load('admin/template', 'contas/editar', $data);
    }

    public function excluir($id){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->ContasModel->ExcluirConta($id);
    }
}
