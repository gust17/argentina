<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backoffice extends MY_Controller {

    public function __construct(){

        parent::__construct();
        isLogged();
        CheckSystemMaintenance();

        $this->load->model('backofficemodel', 'Backoffice');
        $this->load->model('indicados/indicadosmodel', 'IndicadosModel');
        $this->load->model('planos/planosmodel', 'PlanosModel');
        $this->load->model('saques/saquesmodel', 'SaquesModel');
        $this->load->model('extrato/extratomodel', 'ExtratoModel');
    }

	public function index(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = $this->lang->line('meu_backoffice');

        $data['cssLoader'] = array(
            'assets/pages/css/backoffice.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/countdown/jquery.countdown.min.js',
            'assets/plugins/momentjs/js/moment.min.js',
            'https://unpkg.com/swiper/swiper-bundle.min.js',
            'node_modules/atropos/atropos.js',
            'assets/pages/js/backoffice.js'
        );

        $data['jsVar'] = array(
            '__TRANS_LINK_COPIED_TITLE__'=>$this->lang->line('link_copiado_title_ok'),
            '__TRANS_LINK_COPIED__'=>$this->lang->line('link_copiado_ok'),
            '__TRANS_TOUR_PROX__'=>$this->lang->line('bk_tour_proximo_button'),
            '__TRANS_TOUR_ANTER__'=>$this->lang->line('bk_tour_anterior_button'),
            '__TRANS_TOUR_ENCERRAR__'=>$this->lang->line('bk_tour_encerrar_button'),
            '__TRANS_TOUR_MENU_NAVEGACAO_TITLE__'=>$this->lang->line('bk_tour_menu_navegacao_title'),
            '__TRANS_TOUR_MENU_NAVEGACAO_CONTENT__'=>$this->lang->line('bk_tour_menu_navegacao_content'),
            '__TRANS_TOUR_MINHAS_NOTIFICACOES_TITLE__'=>$this->lang->line('bk_tour_minhas_notificacoes_title'),
            '__TRANS_TOUR_MINHAS_NOTIFICACOES_CONTENT__'=>$this->lang->line('bk_tour_minhas_notificacoes_content'),
            '__TRANS_TOUR_LINK_INDICACAO_TITLE__'=>$this->lang->line('bk_tour_link_indicacao_title'),
            '__TRANS_TOUR_LINK_INDICACAO_CONTENT__'=>$this->lang->line('bk_tour_link_indicacao_content'),
            '__TRANS_TOUR_PROXIMO_RENDIMENTO_TITLE__'=>$this->lang->line('bk_tour_proximo_rendimento_title'),
            '__TRANS_TOUR_PROXIMO_RENDIMENTO_CONTENT__'=>$this->lang->line('bk_tour_proximo_rendimento_content'),
            '__TRANS_TOUR_SALDO_RENDIMENTO_TITLE__'=>$this->lang->line('bk_tour_saldo_rendimento_title'),
            '__TRANS_TOUR_SALDO_RENDIMENTO_CONTENT__'=>$this->lang->line('bk_tour_saldo_rendimento_content'),
            '__TRANS_TOUR_SALDO_REDE_TITLE__'=>$this->lang->line('bk_tour_saldo_rede_title'),
            '__TRANS_TOUR_SALDO_REDE_CONTENT__'=>$this->lang->line('bk_tour_saldo_rede_content')
        );

        $data['saldoRendimento'] = $this->SystemModel->RendimentoTotal();
        $data['saldoRede'] = $this->SystemModel->RedeTotal();
        $data['saldoRendimentoEntrada24'] = $this->SystemModel->SaldoUltimosDias(1, 1, 1);
        $data['saldoRendimentoSaida24'] = $this->SystemModel->SaldoUltimosDias(1, 2, 1);
        $data['saldoRedeEntrada24'] = $this->SystemModel->SaldoUltimosDias(1, 1, 2);
        $data['saldoRedeSaida24'] = $this->SystemModel->SaldoUltimosDias(1, 2, 2);
        $data['infoUnilevel'] = $this->IndicadosModel->infoUnilevel();
        $data['clicksLink'] = $this->IndicadosModel->clicksLink();
        $data['planosAtivos'] = $this->PlanosModel->quantidadePlanosAtivos();
        $data['saquesEfetuados'] = $this->SaquesModel->quantidadeSaquesEfetuados();
        $data['ultimasMovimentacoes'] = $this->ExtratoModel->ultimasMovimentacoes(15);
        $data['totalPlanosSistema'] = $this->Backoffice->TotalPlanosSistema();
        $data['rss'] = $this->Backoffice->RSS();
        $data['investimentosDisponiveis'] = $this->Backoffice->InvestimentosDisponiveis();
        $data['levels'] = $this->SystemModel->LeveisDisponiveis();
        $data['flag_investing'] = $this->session->userdata('flag_investing') ?? 'br';
        $data['modalStatus'] = SystemInfo('modal_backoffice_status');
        $data['rotas'] = MinhasRotas();
        $data['score'] = UserInfo('score');

		$this->template->load('cliente/template', 'backoffice', $data);
    }
    
    public function sair(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $this->Backoffice->Logout();
    }
}
