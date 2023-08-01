<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Saques extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        isLogged();
        CheckSystemMaintenance();

        $this->load->model('saquesmodel', 'SaquesModel');
    }

    public function index()
    {

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = $this->lang->line('saq_todos_titulo');

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js',
            'assets/plugins/countdown/jquery.countdown.min.js',
            'assets/plugins/maskmoney/jquery.maskMoney.min.js',
            'assets/pages/js/saques.js'
        );

        $data['jsVar'] = array(
            '__TRANS_DIAS__' => $this->lang->line('dias')
        );

        if ($this->input->post('submit')) {

            $data['message'] = $this->SaquesModel->SolicitarUrgencia();
        }

        $data['saques'] = $this->SaquesModel->MeusSaques();
        $data['solicitacao_total'] = $this->SaquesModel->ValorSaquesSolicitados();
        $data['solicitacao_paga'] = $this->SaquesModel->ValorSaquesSolicitados(1);
        $data['urgente_disponivel'] = $this->SaquesModel->SaquesUrgenciaDisponiveis();
        $data['dias_pagamento_saque'] = SystemInfo('dias_uteis_pagamento_saque');
        $data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_token'] = $this->security->get_csrf_hash();

        $this->template->load('cliente/template', 'todos', $data);
    }

    public function rendimento($id)
    {

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = $this->lang->line('saq_rendimentos_titulo');

        $data['jsLoader'] = array(
            'assets/plugins/maskmoney/jquery.maskMoney.min.js',
            'assets/pages/js/saques.js'
        );

        $data['jsVar'] = array(
            '__TRANS_DIAS__' => $this->lang->line('dias')
        );

        if ($this->input->post('submit')) {
            $data['message'] = $this->SaquesModel->RealizarSaqueRendimento($id);
        }

        $data['bankon'] = UserInfo('bankon');
        $data['newpay'] = UserInfo('newpay');
        $data['conta_bancaria'] = UserInfo('conta_bancaria');
        $data['carteira_bitcoin'] = UserInfo('carteira_bitcoin');
        $data['pix'] = UserInfo('pix');
        $data['simplepay'] = UserInfo('simplepay');

        $data['saldo_disponivel'] = $this->SystemModel->RendimentoDisponivelFatura($id);

        $data['meio_disponivel'] = $this->SaquesModel->MeiosDisponiveis();

        $data['pagamentosTotais'] = $this->SystemModel->VerificaRecebimentoTotal($id);
        $data['quantidadeDiasRendidos'] = $this->SystemModel->TotalDiasRendidos($id);

        $this->template->load('cliente/template', 'rendimentos', $data);
    }

    public function rede()
    {

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = $this->lang->line('saq_rede_titulo');

        $data['jsLoader'] = array(
            'assets/plugins/maskmoney/jquery.maskMoney.min.js',
            'assets/pages/js/saques.js'
        );

        $data['jsVar'] = array(
            '__TRANS_DIAS__' => $this->lang->line('dias')
        );

        if ($this->input->post('submit')) {
            $data['message'] = $this->SaquesModel->RealizarSaqueRede();
        }

        $data['bankon'] = UserInfo('bankon');
        $data['newpay'] = UserInfo('newpay');
        $data['conta_bancaria'] = UserInfo('conta_bancaria');
        $data['carteira_bitcoin'] = UserInfo('carteira_bitcoin');
        $data['pix'] = UserInfo('pix');
        $data['simplepay'] = UserInfo('simplepay');

        $data['saldo_backoffice'] = $this->SystemModel->RedeTotal();

        $data['meio_disponivel'] = $this->SaquesModel->MeiosDisponiveis();

        $this->template->load('cliente/template', 'rede', $data);
    }

    public function cancelar_contrato($id)
    {

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = $this->lang->line('saq_cancelamento_titulo');

        $data['jsLoader'] = array(
            'assets/plugins/maskmoney/jquery.maskMoney.min.js',
            'assets/pages/js/saques.js'
        );

        $data['jsVar'] = array(
            '__TRANS_DIAS__' => $this->lang->line('dias')
        );

        if ($this->input->post('submit')) {
            $data['message'] = $this->SaquesModel->CancelarContrato($id);
        } else {
            $data['cancelamento_ativo'] =  SystemInfo('cancelamento_contrato');
            $data['raiz_sacada'] = InvoiceInfo($id, 'status_saque_raiz');
            $data['habilitado_saque'] = $this->SaquesModel->VerificaDisponibilidadeCancelamento($id);
        }

        $data['taxa_raiz'] = SystemInfo('taxa_saque_raiz');

        $data['bankon'] = UserInfo('bankon');
        $data['newpay'] = UserInfo('newpay');
        $data['conta_bancaria'] = UserInfo('conta_bancaria');
        $data['carteira_bitcoin'] = UserInfo('carteira_bitcoin');
        $data['pix'] = UserInfo('pix');
        $data['simplepay'] = UserInfo('simplepay');

        $data['saldo_raiz'] = InvoiceInfo($id, 'valor');
        $data['cancelamento_taxa'] = SystemInfo('taxa_cancelamento');

        $data['meio_disponivel'] = $this->SaquesModel->MeiosDisponiveis();

        $this->template->load('cliente/template', 'cancelar_contrato', $data);
    }

    public function sacar_raiz($id)
    {

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = $this->lang->line('saq_raiz_titulo');

        $data['jsLoader'] = array(
            'assets/plugins/maskmoney/jquery.maskMoney.min.js',
            'assets/pages/js/saques.js'
        );

        $data['jsVar'] = array(
            '__TRANS_DIAS__' => $this->lang->line('dias')
        );

        if ($this->input->post('submit')) {
            $data['message'] = $this->SaquesModel->SacarRaiz($id);
        }

        $data['raiz_sacada'] = InvoiceInfo($id, 'status_saque_raiz');
        $data['habilitado_saque'] = $this->SaquesModel->VerificaDisponibilidadeCancelamento($id);

        $data['bankon'] = UserInfo('bankon');
        $data['newpay'] = UserInfo('newpay');
        $data['conta_bancaria'] = UserInfo('conta_bancaria');
        $data['carteira_bitcoin'] = UserInfo('carteira_bitcoin');
        $data['pix'] = UserInfo('pix');
        $data['simplepay'] = UserInfo('simplepay');

        $data['saldo_raiz'] = InvoiceInfo($id, 'valor');
        $data['taxa_raiz'] = SystemInfo('taxa_saque_raiz');

        $data['meio_disponivel'] = $this->SaquesModel->MeiosDisponiveis();

        $this->template->load('cliente/template', 'raiz', $data);
    }
}
