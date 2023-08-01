<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracoes extends MY_Controller {

    public function __construct(){
        parent::__construct();

        isLoggedAdmin();
        EnabledMasterKey(true);

        $this->permission->AuthorizationWithRedirect('configuracoes');
        
        $this->load->model('configuracoesmodel', 'ConfiguracoesModel');
        $this->load->model('usuariosmodel', 'UsuariosModel');
    }

    public function site(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('configuracoes.site');

        $data['nome_pagina'] = 'Editar configurações do site';

        $data['cssLoader'] = array(
            'assets/cliente/default/assets/css/plugins/select2.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/ckeditor5/build/ckeditor.js',
            'assets/plugins/maskedinput/jquery.maskedinput.min.js',
            'assets/cliente/default/assets/js/plugins/select2.full.min.js',
            'assets/pages/js/admin/configuracoes.js'
        );

        if($this->input->post('submit')){
            $data['message'] = $this->ConfiguracoesModel->EditarSite();
        }

        if($this->input->post('submit2')){
            $data['message'] = $this->ConfiguracoesModel->EditarCancelamentoContrato();
        }

        if($this->input->post('submit3')){
            $data['message'] = $this->ConfiguracoesModel->EditarLogos();
        }

        if($this->input->post('submit4')){
            $data['message'] = $this->ConfiguracoesModel->EditarSMTP();
        }

        if($this->input->post('submit5')){
            $data['message'] = $this->ConfiguracoesModel->EditarServidor();
        }

        $data['habilitar_cancelamento'] = SystemInfo('cancelamento_contrato');
        $data['modal_backoffice_status'] = SystemInfo('modal_backoffice_status');

        $data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_token'] = $this->security->get_csrf_hash();

        $data['usuarios'] = $this->UsuariosModel->TodosUsuarios();

		$this->template->load('admin/template', 'configuracoes/site', $data);
    }

    public function saque(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('configuracoes.saque');

        $data['nome_pagina'] = 'Editar configurações do saque';

        $data['jsLoader'] = array(
            'assets/plugins/maskmoney/jquery.maskMoney.min.js',
            'assets/plugins/maskedinput/jquery.maskedinput.min.js',
            'assets/pages/js/admin/configuracoes.js'
        );

        if($this->input->post('submitGeral')){
            $data['message'] = $this->ConfiguracoesModel->EditarSaque();
        }

        if($this->input->post('submitRendimento')){
            $data['message'] = $this->ConfiguracoesModel->EditarRendimento();
        }

        if($this->input->post('submitRede')){
            $data['message'] = $this->ConfiguracoesModel->EditarRede();
        }

        if($this->input->post('submitRaiz')){
            $data['message'] = $this->ConfiguracoesModel->EditarRaiz();
        }

        $data['meios_saques'] = MeiosDisponiveisSaque();
        $data['dias_semana'] = DiasSemana();
        $data['pagamento_raiz'] = SystemInfo('pagamento_raiz');
        $data['regra_saque'] = SystemInfo('sacar_rendimento_apos_vencido');
        $data['dias_uteis'] = SystemInfo('dias_uteis_pagamento_saque');
        $data['prazo_urgencia'] = SystemInfo('prazo_saque_urgencia');
        $data['saque_liberado'] = SystemInfo('saque_liberado');
        $data['configuracoes_saque_rendimento'] = json_decode(SystemInfo('configuracoes_saque_rendimento'), true);
        $data['configuracoes_saque_rede'] = json_decode(SystemInfo('configuracoes_saque_rede'), true);
        $data['taxa_saque_raiz'] = SystemInfo('taxa_saque_raiz');
        $data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $data['meios_disponiveis'] = json_decode(SystemInfo('meios_disponiveis_saque'));

		$this->template->load('admin/template', 'configuracoes/saque', $data);
    }

    public function pix(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('configuracoes.pix');

        $data['nome_pagina'] = 'Editar Chave Pix';

        if($this->input->post('submit')){
            $data['message'] = $this->ConfiguracoesModel->EditarPix();
        }

        if($this->input->post('submit2')){
            $data['message'] = $this->ConfiguracoesModel->EditarPixGerencianet();
        }

        $data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_token'] = $this->security->get_csrf_hash();

		$this->template->load('admin/template', 'configuracoes/pix', $data);
    }

	public function bankon(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('configuracoes.bankon');

        $data['nome_pagina'] = 'Editar configurações da API da BankOn';

        if($this->input->post('submit')){
            $data['message'] = $this->ConfiguracoesModel->EditarBankOn();
        }

		$this->template->load('admin/template', 'configuracoes/bankon', $data);
    }

    public function simplepay(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('configuracoes.simplepay');

        $data['nome_pagina'] = 'Editar configurações da API da SimplePay';

        if($this->input->post('submit')){
            $data['message'] = $this->ConfiguracoesModel->EditarSimplePay();
        }

		$this->template->load('admin/template', 'configuracoes/simplepay', $data);
    }

    public function coinpayments(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('configuracoes.coinpayments');

        $data['nome_pagina'] = 'Editar configurações da API da CoinPayments';

        $data['cssLoader'] = array(
            'assets/cliente/default/assets/css/plugins/select2.min.css'
        );

        $data['jsLoader'] = array(
            'assets/cliente/default/assets/js/plugins/select2.full.min.js',
            'assets/pages/js/admin/configuracoes.js'
        );

        if($this->input->post('submit')){
            $data['message'] = $this->ConfiguracoesModel->EditarCoinpayments();
        }

        $data['cryptosDB'] = json_decode(SystemInfo('coinpayments_cryptos'), true);

		$this->template->load('admin/template', 'configuracoes/coinpayments', $data);
    }

    public function grupos(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('configuracoes.grupos');

        $data['nome_pagina'] = 'Editar configurações de Grupos';
        $data['jsLoader'] = array(
            'assets/pages/js/admin/configuracoes.js'
        );

        if($this->input->post('submit')){
            $data['message'] = $this->ConfiguracoesModel->SalvarGrupos();
        }

        $data['grupos'] = json_decode(SystemInfo('grupos_afiliados'), true);

		$this->template->load('admin/template', 'configuracoes/grupos', $data);
    }

    public function recaptcha(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('configuracoes.recaptcha');

        $data['nome_pagina'] = 'Editar configurações da API do Recaptcha';

        if($this->input->post('submit')){
            $data['message'] = $this->ConfiguracoesModel->EditarRecaptcha();
        }

        $data['recaptcha_align'] = SystemInfo('recaptcha_align');

		$this->template->load('admin/template', 'configuracoes/recaptcha', $data);
    }

    public function twilio(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('configuracoes.twillio');

        $data['nome_pagina'] = 'Editar configurações da API Twilio';

        if($this->input->post('submit')){
            $data['message'] = $this->ConfiguracoesModel->EditarAuthy();
        }

        if($this->input->post('submit2')){
            $data['message'] = $this->ConfiguracoesModel->EditarTwilioSMS();
        }

        $data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_token'] = $this->security->get_csrf_hash();

		$this->template->load('admin/template', 'configuracoes/twilio', $data);
    }

    public function asaas(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('configuracoes.asaas');

        $data['nome_pagina'] = 'Editar configurações da API Asaas';

        if($this->input->post('submit')){
            $data['message'] = $this->ConfiguracoesModel->EditarAsaas();
        }

		$this->template->load('admin/template', 'configuracoes/asaas', $data);
    }

    public function telegram(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $data['nome_pagina'] = 'Editar configurações do Telegram';

        if($this->input->post('submit')){
            $data['message'] = $this->ConfiguracoesModel->EditarTelegram();
        }

		$this->template->load('admin/template', 'configuracoes/telegram', $data);
    }
}
