<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Faturas extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        isLogged();
        CheckSystemMaintenance();

        $this->load->model('faturasmodel', 'FaturasModel');
    }

    public function index()
    {

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = $this->lang->line('fat_titulo');

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js'
        );

        $data['rotas'] = MinhasRotas();
        $data['faturas'] = $this->FaturasModel->MinhasFaturas();

        $this->template->load('cliente/template', 'todas', $data);
    }

    public function pagamento($id)
    {

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = $this->lang->line('fat_pagamento_titulo');

        $data['cssLoader'] = array(
            'assets/cliente/default/assets/css/plugins/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js',
            'assets/pages/js/faturas.js'
        );

        $data['jsVar'] = array(
            '__TRANS_GERANDO_CARTEIRA__' => $this->lang->line('fat_gerando_carteira_js'),
            '__TRANS_GERANDO_FRACAO__' => $this->lang->line('fat_gerando_fracao_js'),
            '__TRANS_GERANDO_BUTTON__' => $this->lang->line('fat_gerando_carteira_button_js'),
            '__TRANS_ERRO__' => $this->lang->line('erro')
        );

        if ($this->input->post('EnviarComprovante')) {
            $data['message'] = $this->FaturasModel->EnviarComprovante($id);
        }

        if ($this->input->post('AtivarBankOn')) {
            $data['message'] = $this->FaturasModel->AtivarBankOn($id);
        }

        if ($this->input->post('AtivarSimplepay')) {
            $data['message'] = $this->FaturasModel->AtivarSimplePay($id);
        }

        if ($this->input->post('AtivarPix')) {
            $data['message'] = $this->FaturasModel->EnviarComprovante($id);
        }

        if ($this->input->post('GerarBoletoAsaas')) {
            $this->FaturasModel->GerarBoletoAsaas($id);
            exit;
        }

        $data['contas'] = $this->FaturasModel->BancosCadastrados();
        $data['fatura'] = $this->FaturasModel->MinhaFatura($id);

        $data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();

        // $data['qrcode'] = $this->FaturasModel->GerarPix($id);

        $data['cryptosDB'] = json_decode(SystemInfo('coinpayments_cryptos'), true);

        $data['asaasHabilitado'] = SystemInfo('asaas_habilitado');
        $data['bankonHabilitado'] = SystemInfo('habilitar_bankon');
        $data['pixHabilitado'] = SystemInfo('habilitar_pix');
        $data['coinpaymentsHabilitado'] = SystemInfo('coinpayments_habilitar');
        $data['simplepayHabilitado'] = SystemInfo('habilitar_simplepay');

        $this->template->load('cliente/template', 'pagamento', $data);
    }

    public function excluir($id)
    {

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $this->FaturasModel->ExcluirFatura($id);
    }
}
