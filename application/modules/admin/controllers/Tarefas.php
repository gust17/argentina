<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarefas extends MY_Controller {

    public function __construct(){
        parent::__construct();
        
        isLoggedAdmin();

        $this->permission->AuthorizationWithRedirect('tarefas');
        
        $this->load->model('tarefasmodel', 'TarefasModel');
    }

	public function enviados(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('tarefas.enviados');

        $data['nome_pagina'] = 'Tarefas Enviadas';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js',
            'assets/pages/js/admin/tarefas.js'
        );
        
        $data['tarefas'] = $this->TarefasModel->TodasTarefas(0);

		$this->template->load('admin/template', 'tarefas/todos', $data);
    }

    public function aprovadas(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('tarefas.enviados');

        $data['nome_pagina'] = 'Tarefas Enviadas';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js',
            'assets/pages/js/admin/tarefas.js'
        );
        
        $data['tarefas'] = $this->TarefasModel->TodasTarefas(1);

		$this->template->load('admin/template', 'tarefas/todos', $data);
    }

    public function rejeitadas(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('tarefas.enviados');

        $data['nome_pagina'] = 'Tarefas Enviadas';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js',
            'assets/pages/js/admin/tarefas.js'
        );
        
        $data['tarefas'] = $this->TarefasModel->TodasTarefas(2);

		$this->template->load('admin/template', 'tarefas/todos', $data);
    }

    public function aprovar($id){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('tarefas.aprovar');

        $this->TarefasModel->Aprovar($id);
    }

    public function rejeitar($id){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('tarefas.rejeitar');

        $this->TarefasModel->Rejeitar($id);
    }
}
