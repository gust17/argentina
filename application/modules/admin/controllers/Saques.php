<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Saques extends MY_Controller {

    public function __construct(){
        parent::__construct();

        isLoggedAdmin();

        $this->permission->AuthorizationWithRedirect('saques');
        
        $this->load->model('saquesmodel', 'SaquesModel');
    }

	public function index(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('saques.todos');

        $data['nome_pagina'] = 'Lista de todos os saques';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js',
            'assets/pages/js/admin/saques.js'
        );

        $data['saques'] = $this->SaquesModel->TodosSaques();
        $data['dias_pagamento_saque'] = SystemInfo('dias_uteis_pagamento_saque');

        $data['permitidoVisualizar'] = $this->permission->Authorization('saques.visualizar');
        $data['permitidoBaixa'] = $this->permission->Authorization('saques.baixa');
        $data['permitidoEstornar'] = $this->permission->Authorization('saques.estornar');
        $data['permitidoExcluir'] = $this->permission->Authorization('saques.excluir');

		$this->template->load('admin/template', 'saques/saques', $data);
    }

    public function pendentes(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('saques.pendentes');

        $data['nome_pagina'] = 'Lista de todos os saques pendentes';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js',
            'assets/pages/js/admin/saques.js'
        );

        $data['saques'] = $this->SaquesModel->TodosSaques(0);
        $data['dias_pagamento_saque'] = SystemInfo('dias_uteis_pagamento_saque');

        $data['permitidoVisualizar'] = $this->permission->Authorization('saques.visualizar');
        $data['permitidoBaixa'] = $this->permission->Authorization('saques.baixa');
        $data['permitidoEstornar'] = $this->permission->Authorization('saques.estornar');
        $data['permitidoExcluir'] = $this->permission->Authorization('saques.excluir');

		$this->template->load('admin/template', 'saques/saques', $data);
    }

    public function pendentes_urgente(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('saques.pendentes');

        $data['nome_pagina'] = 'Lista de todos os saques pendentes com URGÊNCIA';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js',
            'assets/pages/js/admin/saques.js'
        );

        $data['saques'] = $this->SaquesModel->TodosSaques(0, false, 1);
        $data['dias_pagamento_saque'] = SystemInfo('dias_uteis_pagamento_saque');

        $data['permitidoVisualizar'] = $this->permission->Authorization('saques.visualizar');
        $data['permitidoBaixa'] = $this->permission->Authorization('saques.baixa');
        $data['permitidoEstornar'] = $this->permission->Authorization('saques.estornar');
        $data['permitidoExcluir'] = $this->permission->Authorization('saques.excluir');

		$this->template->load('admin/template', 'saques/saques', $data);
    }

    public function pagos(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('saques.pagos');

        $data['nome_pagina'] = 'Lista de todos os saques pagos';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js'
        );

        $data['saques'] = $this->SaquesModel->TodosSaques(1);
        $data['dias_pagamento_saque'] = SystemInfo('dias_uteis_pagamento_saque');

        $data['permitidoVisualizar'] = $this->permission->Authorization('saques.visualizar');
        $data['permitidoBaixa'] = $this->permission->Authorization('saques.baixa');
        $data['permitidoEstornar'] = $this->permission->Authorization('saques.estornar');
        $data['permitidoExcluir'] = $this->permission->Authorization('saques.excluir');

		$this->template->load('admin/template', 'saques/saques', $data);
    }

    public function estornados(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('saques.estornados');

        $data['nome_pagina'] = 'Lista de todos os saques estornados';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js'
        );

        $data['saques'] = $this->SaquesModel->TodosSaques(2);
        $data['dias_pagamento_saque'] = SystemInfo('dias_uteis_pagamento_saque');

        $data['permitidoVisualizar'] = $this->permission->Authorization('saques.visualizar');
        $data['permitidoBaixa'] = $this->permission->Authorization('saques.baixa');
        $data['permitidoEstornar'] = $this->permission->Authorization('saques.estornar');
        $data['permitidoExcluir'] = $this->permission->Authorization('saques.excluir');

		$this->template->load('admin/template', 'saques/saques', $data);
    }

    public function visualizar($id){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('saques.visualizar');

        $data['nome_pagina'] = 'Visualizar Saque';

        $data['jsLoader'] = array(
            'assets/pages/js/admin/saques.js'
        );

        $data['rotas'] = MinhasRotas();

        $data['saque'] = $this->SaquesModel->InformacaoSaque($id);
        $data['dias_pagamento_saque'] = SystemInfo('dias_uteis_pagamento_saque');

        $data['qrCodePix'] = $this->SaquesModel->GerarQRCodePix($id);

        $data['permitidoVisualizar'] = $this->permission->Authorization('saques.visualizar');
        $data['permitidoBaixa'] = $this->permission->Authorization('saques.baixa');
        $data['permitidoEstornar'] = $this->permission->Authorization('saques.estornar');
        $data['permitidoExcluir'] = $this->permission->Authorization('saques.excluir');

		$this->template->load('admin/template', 'saques/visualizar', $data);
    }

    public function previsao(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('saques.previsao');

        $data['nome_pagina'] = 'Previsão de Saque';

        $data['cssLoader'] = array(
            'assets/admin/assets/css/custom.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js',
        );

        $data['rotas'] = MinhasRotas();

        $data['listaPrevisaoRendimento'] = $this->SaquesModel->listaPrevisaoRendimento();
        $data['previsaoRede'] = $this->SaquesModel->PrevisaoRede();

		$this->template->load('admin/template', 'saques/previsao', $data);
    }

    public function excluir($id){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);
        EnabledMasterKey(true);

        $this->permission->AuthorizationWithRedirect('saques.excluir');

        $this->SaquesModel->ExcluirSaque($id);
    }

    public function baixa($id){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);
        EnabledMasterKey(true);

        $this->permission->AuthorizationWithRedirect('saques.baixa');

        $this->SaquesModel->DarBaixa($id);
    }

    public function estornar($id){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);
        EnabledMasterKey(true);

        $this->permission->AuthorizationWithRedirect('saques.estornar');

        $this->SaquesModel->EstornarSaque($id);
    }
}
