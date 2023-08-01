<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Faturas extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        isLoggedAdmin();

        $this->permission->AuthorizationWithRedirect('faturas');

        $this->load->model('faturasmodel', 'FaturasModel');
    }

    public function index()
    {

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('faturas.todas');

        $data['nome_pagina'] = 'Lista de todas as faturas';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js'
        );

        $data['faturas'] = $this->FaturasModel->TodasFaturas();

        $data['permitidoNormalmente'] = $this->permission->Authorization('faturas.normalmente');
        $data['permitidoCortesia'] = $this->permission->Authorization('faturas.cortesia');
        $data['permitidoExcluir'] = $this->permission->Authorization('faturas.excluir');

        $this->template->load('admin/template', 'faturas/faturas', $data);
    }

    public function pendentes()
    {

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('faturas.pendentes');

        $data['nome_pagina'] = 'Lista de todas as faturas pendentes';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js'
        );

        $data['faturas'] = $this->FaturasModel->TodasFaturas(0);

        $data['permitidoNormalmente'] = $this->permission->Authorization('faturas.normalmente');
        $data['permitidoCortesia'] = $this->permission->Authorization('faturas.cortesia');
        $data['permitidoExcluir'] = $this->permission->Authorization('faturas.excluir');

        $this->template->load('admin/template', 'faturas/faturas', $data);
    }

    public function ativas()
    {

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('faturas.ativas');

        $data['nome_pagina'] = 'Lista de todas as faturas ativas';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js'
        );

        $data['faturas'] = $this->FaturasModel->TodasFaturas(1);

        $data['permitidoNormalmente'] = $this->permission->Authorization('faturas.normalmente');
        $data['permitidoCortesia'] = $this->permission->Authorization('faturas.cortesia');
        $data['permitidoExcluir'] = $this->permission->Authorization('faturas.excluir');

        $this->template->load('admin/template', 'faturas/faturas', $data);
    }

    public function expiradas()
    {

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('faturas.expiradas');

        $data['nome_pagina'] = 'Lista de todas as faturas expiradas';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js'
        );

        $data['faturas'] = $this->FaturasModel->TodasFaturas(2);

        $data['permitidoNormalmente'] = $this->permission->Authorization('faturas.normalmente');
        $data['permitidoCortesia'] = $this->permission->Authorization('faturas.cortesia');
        $data['permitidoExcluir'] = $this->permission->Authorization('faturas.excluir');

        $this->template->load('admin/template', 'faturas/faturas', $data);
    }

    public function excluir($id)
    {

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);
        EnabledMasterKey(true);

        $this->permission->AuthorizationWithRedirect('faturas.excluir');

        $this->FaturasModel->ExcluirFatura($id);
    }

    public function ativar($id)
    {

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);
        EnabledMasterKey(true);

        $this->permission->AuthorizationWithRedirect('faturas.normalmente');

        $this->FaturasModel->AtivarFatura($id);
    }

    public function cortesia($id)
    {

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);
        EnabledMasterKey(true);

        $this->permission->AuthorizationWithRedirect('faturas.cortesia');

        $this->FaturasModel->AtivarFaturaCortesia($id);
    }
}
