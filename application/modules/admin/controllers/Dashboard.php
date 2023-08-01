<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct(){
        parent::__construct();

        isLoggedAdmin();

        $this->load->model('dashboardmodel', 'DashboardModel');
        $this->load->model('faturasmodel', 'FaturasModel');
        $this->load->model('saquesmodel', 'SaquesModel');
        $this->load->model('usuariosmodel', 'UsuariosModel');
        $this->load->model('logsmodel', 'LogsModel');
    }

	public function index(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $data['nome_pagina'] = 'Dashboard Administrativo';

        $data['jsLoader'] = array(
            'assets/admin/assets/libs/apexcharts/apexcharts.min.js',
            'assets/admin/assets/js/pages/dashboard.init.js'
        );

        $data['rotas'] = MinhasRotas();
        $data['LogsAdmin'] = $this->LogsModel->TodosLogs(10);
        $data['EntradasTotais'] = $this->FaturasModel->EntradasTotais();
        $data['FaturasAtivas'] = $this->FaturasModel->FaturasStatus(1);
        $data['FaturasPendentes'] = $this->FaturasModel->FaturasStatus(0);
        $data['UsuariosCadastrados'] = $this->UsuariosModel->QuantidadeUsuarios();
        $data['UsuariosAtivos'] = $this->UsuariosModel->QuantidadeUsuariosStatus(1);
        $data['TopLideres'] = $this->UsuariosModel->TopLideres(10);
        $data['SaidasTotais'] = $this->SaquesModel->SaidasTotais();
        $data['SaquesPagos'] = $this->SaquesModel->SaquesStatus(1);
        $data['SaquesPendentes'] = $this->SaquesModel->SaquesStatus(0);
        $data['ListaSaques'] = $this->SaquesModel->TodosSaques(0, 15);
        $data['SaquesPorPlataforma'] = $this->SaquesModel->SaquesPorPlataformas();
        $data['diasUteis'] = SystemInfo('dias_uteis_pagamento_saque');
        $data['cores'] = [1=>'success', 'warning', 'info', 'danger', 'primary', 'secondary'];

		$this->template->load('admin/template', 'dashboard/dashboard', $data);
    }

    public function notauthorized(){

        echo '<div style="height:100vh;position:relative;"><iframe src="https://giphy.com/embed/ethC2XItDuRdNkGr77" width="100%" height="100%" style="position:absolute" frameBorder="0" class="giphy-embed" allowFullScreen></iframe></div>';
    }

    public function logout(){

        $this->DashboardModel->Deslogar();
    }
}
