<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validacao extends MY_Controller {

    public function __construct(){
        parent::__construct();
        
        isLoggedAdmin();

        $this->permission->AuthorizationWithRedirect('validacao');
        
        $this->load->model('validacaomodel', 'ValidacaoModel');
    }

	public function todos(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('validacao.pendentes');

        $data['nome_pagina'] = 'Validar Documentos';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js',
            'assets/pages/js/admin/validacao.js'
        );
        
        $data['documentos'] = $this->ValidacaoModel->Documentos(0);

		$this->template->load('admin/template', 'validacao/todos', $data);
    }

    public function aprovados(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('validacao.aprovadas');

        $data['nome_pagina'] = 'Documentos aprovados';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js',
            'assets/pages/js/admin/validacao.js'
        );
        
        $data['documentos'] = $this->ValidacaoModel->Documentos(0);

		$this->template->load('admin/template', 'validacao/todos', $data);
    }

    public function rejeitados(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('validacao.rejeitados');

        $data['nome_pagina'] = 'Documentos Rejeitados';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js',
            'assets/pages/js/admin/validacao.js'
        );
        
        $data['documentos'] = $this->ValidacaoModel->Documentos(2);

		$this->template->load('admin/template', 'validacao/todos', $data);
    }

    public function aprovar($id){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('validacao.aprovar');

        $this->ValidacaoModel->Aprovar($id);
    }

    public function rejeitar($id){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('validacao.rejeitar');

        $this->ValidacaoModel->Rejeitar($id);
    }
}
