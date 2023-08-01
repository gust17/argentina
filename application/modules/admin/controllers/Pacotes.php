<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pacotes extends MY_Controller {

    public function __construct(){
        parent::__construct();

        isLoggedAdmin();
        EnabledMasterKey(true);

        $this->permission->AuthorizationWithRedirect('configuracoes.pacotes');
        
        $this->load->model('pacotesmodel', 'PacotesModel');
    }

	public function index(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $data['nome_pagina'] = 'Lista de Pacotes';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js'
        );

        $data['pacotes'] = $this->PacotesModel->TodosPacotes();

		$this->template->load('admin/template', 'pacotes/pacotes', $data);
    }

    public function novo(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $data['nome_pagina'] = 'Novo Pacote';

        $data['rotas'] = MinhasRotas();

        $data['jsLoader'] = array(
            'assets/plugins/maskmoney/jquery.maskMoney.min.js',
            'assets/pages/js/admin/pacotes.js'
        );

        if($this->input->post('submit')){
            $data['message'] = $this->PacotesModel->AdicionarPacote();
        }

		$this->template->load('admin/template', 'pacotes/novo', $data);
    }

    public function editar($id){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $data['nome_pagina'] = 'Editar Pacote';

        $data['rotas'] = MinhasRotas();

        $data['jsLoader'] = array(
            'assets/plugins/maskmoney/jquery.maskMoney.min.js',
            'assets/pages/js/admin/pacotes.js'
        );

        if($this->input->post('submit')){
            $data['message'] = $this->PacotesModel->EditarPacote($id);
        }

        $data['pacote'] = $this->PacotesModel->InformacoesPacote($id);

		$this->template->load('admin/template', 'pacotes/editar', $data);
    }

    public function excluir($id){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->PacotesModel->ExcluirPacote($id);
    }
}
