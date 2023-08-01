<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comprovantes extends MY_Controller {

    public function __construct(){
        parent::__construct();

        isLoggedAdmin();

        $this->permission->AuthorizationWithRedirect('comprovantes');
        
        $this->load->model('comprovantesmodel', 'ComprovantesModel');
    }

	public function index(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('comprovantes.todos');

        $data['nome_pagina'] = 'Lista de todos os comprovantes';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js',
            'assets/pages/js/admin/comprovantes.js'
        );

        $data['comprovantes'] = $this->ComprovantesModel->TodosComprovantes();

        $data['permitidoAtivar'] = $this->permission->Authorization('comprovantes.ativar');
        $data['permitidoRejeitar'] = $this->permission->Authorization('comprovantes.rejeitar');
        $data['permitidoExcluir'] = $this->permission->Authorization('comprovantes.excluir');

		$this->template->load('admin/template', 'comprovantes/comprovantes', $data);
    }

    public function pendentes(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('comprovantes.pendentes');

        $data['nome_pagina'] = 'Lista de todos os comprovantes pendentes';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js',
            'assets/pages/js/admin/comprovantes.js'
        );

        $data['comprovantes'] = $this->ComprovantesModel->TodosComprovantes(0);

        $data['permitidoAtivar'] = $this->permission->Authorization('comprovantes.ativar');
        $data['permitidoRejeitar'] = $this->permission->Authorization('comprovantes.rejeitar');
        $data['permitidoExcluir'] = $this->permission->Authorization('comprovantes.excluir');

		$this->template->load('admin/template', 'comprovantes/comprovantes', $data);
    }

    public function aprovados(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('comprovantes.aprovados');

        $data['nome_pagina'] = 'Lista de todos os comprovantes aprovados';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js',
            'assets/pages/js/admin/comprovantes.js'
        );

        $data['comprovantes'] = $this->ComprovantesModel->TodosComprovantes(1);

        $data['permitidoAtivar'] = $this->permission->Authorization('comprovantes.ativar');
        $data['permitidoRejeitar'] = $this->permission->Authorization('comprovantes.rejeitar');
        $data['permitidoExcluir'] = $this->permission->Authorization('comprovantes.excluir');

		$this->template->load('admin/template', 'comprovantes/comprovantes', $data);
    }

    public function rejeitados(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('comprovantes.rejeitados');

        $data['nome_pagina'] = 'Lista de todos os comprovantes';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js',
            'assets/pages/js/admin/comprovantes.js'
        );

        $data['comprovantes'] = $this->ComprovantesModel->TodosComprovantes(2);

        $data['permitidoAtivar'] = $this->permission->Authorization('comprovantes.ativar');
        $data['permitidoRejeitar'] = $this->permission->Authorization('comprovantes.rejeitar');
        $data['permitidoExcluir'] = $this->permission->Authorization('comprovantes.excluir');

		$this->template->load('admin/template', 'comprovantes/comprovantes', $data);
    }

    public function excluir($id){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);
        EnabledMasterKey(true);

        $this->permission->AuthorizationWithRedirect('comprovantes.excluir');

        $this->ComprovantesModel->ExcluirComprovante($id);
    }

    public function aprovar($id){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);
        EnabledMasterKey(true);

        $this->permission->AuthorizationWithRedirect('comprovantes.ativar');

        $this->ComprovantesModel->AprovarComprovante($id);
    }

    public function rejeitar($id){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);
        EnabledMasterKey(true);

        $this->permission->AuthorizationWithRedirect('comprovantes.rejeitar');

        $this->ComprovantesModel->RejeitarComprovante($id);
    }
}
