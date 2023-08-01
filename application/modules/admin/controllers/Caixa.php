<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Caixa extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        isLoggedAdmin();

        $this->permission->AuthorizationWithRedirect('caixa');

        $this->load->model('caixamodel', 'CaixaModel');
    }

    public function index()
    {

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $data['nome_pagina'] = 'Caixa da Empresa';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js'
        );

        $data['registros'] = $this->CaixaModel->TodosRegistros();
        $data['EntradasTotais'] = $this->CaixaModel->EntradasTotais();
        $data['SaidasTotais'] = $this->CaixaModel->SaidasTotais();
        $data['CustosEmpresa'] = $this->CaixaModel->SaidasTotais(3);
        $data['SaidaPablo'] = $this->CaixaModel->SaidasTotais(4);
        $data['SaidaLois'] = $this->CaixaModel->SaidasTotais(5);
        $data['SaidaWalerio'] = $this->CaixaModel->SaidasTotais(6);
        $data['SaidaBada'] = $this->CaixaModel->SaidasTotais(7);
        $data['SaidaAlisson'] = $this->CaixaModel->SaidasTotais(8);
        $data['SaidaErick'] = $this->CaixaModel->SaidasTotais(9);

        $data['permitidoAdicionar'] = $this->permission->Authorization('caixa.adicionar');

        $this->template->load('admin/template', 'caixa/lista', $data);
    }

    public function adicionar()
    {

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('caixa.adicionar');

        $data['nome_pagina'] = 'Adicionar Registro';

        $data['jsLoader'] = array(
            'assets/plugins/maskmoney/jquery.maskMoney.min.js',
            'assets/pages/js/admin/caixa.js'
        );

        $data['rotas'] = MinhasRotas();

        if ($this->input->post('descricao')) {

            $data['message'] = $this->CaixaModel->AdicionarRegistro();
        }

        $this->template->load('admin/template', 'caixa/adicionar', $data);
    }
}
