<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indicados extends MY_Controller {

    public function __construct(){
        parent::__construct();
        isLogged();
        CheckSystemMaintenance();

        $this->load->model('indicadosmodel', 'IndicadosModel');
    }

	public function unilevel(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = $this->lang->line('ind_unilevel_titulo');

        $data['cssLoader'] = array(
            'assets/cliente/default/assets/css/plugins/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/cliente/default/assets/js/plugins/jquery.dataTables.min.js',
            'assets/cliente/default/assets/js/plugins/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js'
        );

        $data['unilevel'] = $this->IndicadosModel->MyUnilevel();
        $data['quantidade_niveis'] = SystemInfo('niveis_unilevel');

		$this->template->load('cliente/template', 'unilevel', $data);
    }
    
    public function ativos(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = $this->lang->line('ind_ativos_titulo');

        $data['cssLoader'] = array(
            'assets/cliente/default/assets/css/plugins/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/cliente/default/assets/js/plugins/jquery.dataTables.min.js',
            'assets/cliente/default/assets/js/plugins/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js'
        );

        $data['indicados'] = $this->IndicadosModel->ListarIndicados(1);

		$this->template->load('cliente/template', 'ativos', $data);
    }
    
    public function pendentes(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = $this->lang->line('ind_pendentes_titulo');;

        $data['cssLoader'] = array(
            'assets/cliente/default/assets/css/plugins/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/cliente/default/assets/js/plugins/jquery.dataTables.min.js',
            'assets/cliente/default/assets/js/plugins/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js'
        );

        $data['indicados'] = $this->IndicadosModel->ListarIndicados(0);

		$this->template->load('cliente/template', 'pendentes', $data);
    }
    
    public function relatorio(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = $this->lang->line('ind_relatorio_titulo');

        $data['cssLoader'] = array(
            'assets/cliente/default/assets/css/plugins/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/cliente/default/assets/js/plugins/jquery.dataTables.min.js',
            'assets/cliente/default/assets/js/plugins/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js',
            'assets/pages/js/indicados.js'
        );

        $data['jsVar'] = array(
            '__TRANS_LINK_COPIADO_TITLE__'=>$this->lang->line('link_copiado_title_ok'),
            '__TRANS_LINK_COPIADO_CONTENT__'=>$this->lang->line('link_copiado_ok'),
            '__TRANS_BINARIO_ATIVO__'=>$this->lang->line('ind_binario_ativo_js'),
            '__TRANS_BINARIO_INATIVO__'=>$this->lang->line('ind_binario_inativo_js'),
            '__TRANS_CADASTRO_ATIVO__'=>$this->lang->line('ind_cadastro_ativo_js'),
            '__TRANS_CADASTRO_INATIVO__'=>$this->lang->line('ind_cadastro_inativo_js'),
            '__TRANS_CADASTROS_P__'=>$this->lang->line('ind_cadastro_plural_js'),
            '__TRANS_ERRO_TITLE__'=>$this->lang->line('erro'),
            '__TRANS_ERRO_REQUISICAO__'=>$this->lang->line('ind_erro_requisicao_js'),
            '__TRANS_BIN_LADO_ESQUERDO__'=>$this->lang->line('ind_binario_lado_esquerdo'),
            '__TRANS_BIN_LADO_DIREITO__'=>$this->lang->line('ind_binario_lado_direito'),
            '__TRANS_TUDO_CERTO__'=>$this->lang->line('ind_tudo_certo_js'),
            '__TRANS_CHAVE_BINARIA_OK__'=>$this->lang->line('ind_chave_binaria_alterada_ok')
        );

        if($this->input->post('qualificar')){

            $data['message'] = $this->IndicadosModel->EnviarPesquisaPatrocinador();
        }

        $data['indicadosAtivos'] = $this->IndicadosModel->quantidadeIndicados(1);
        $data['indicadosPendentes'] = $this->IndicadosModel->quantidadeIndicados(0);
        $data['clicksLink'] = $this->IndicadosModel->clicksLink();
        $data['cadastros'] = $this->IndicadosModel->ListarUltimosCadastrados(10);
        $data['patrocinador'] = $this->IndicadosModel->MySponsorInfo();
        $data['pesquisa'] = $this->IndicadosModel->PesquisaPatrocinadorEnviada();
        $data['rotas'] = MinhasRotas();

		$this->template->load('cliente/template', 'relatorio', $data);
	}

    public function binario(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $checkIsSearch = $this->IndicadosModel->checkIsSearch();

        $data['nome_pagina'] = $this->lang->line('ind_binario_titulo');

        $data['redeHabilitada'] = 1;

        $data['cssLoader'] = array(
            'assets/pages/css/rede.css'
        );

        $data['jsLoader'] = array(
            'assets/pages/js/indicados.js'
        );

        $data['jsVar'] = array(
            '__TRANS_LINK_COPIADO_TITLE__'=>$this->lang->line('link_copiado_title_ok'),
            '__TRANS_LINK_COPIADO_CONTENT__'=>$this->lang->line('link_copiado_ok'),
            '__TRANS_BINARIO_ATIVO__'=>$this->lang->line('ind_binario_ativo_js'),
            '__TRANS_BINARIO_INATIVO__'=>$this->lang->line('ind_binario_inativo_js'),
            '__TRANS_CADASTRO_ATIVO__'=>$this->lang->line('ind_cadastro_ativo_js'),
            '__TRANS_CADASTRO_INATIVO__'=>$this->lang->line('ind_cadastro_inativo_js'),
            '__TRANS_CADASTROS_P__'=>$this->lang->line('ind_cadastro_plural_js'),
            '__TRANS_ERRO_TITLE__'=>$this->lang->line('erro'),
            '__TRANS_ERRO_REQUISICAO__'=>$this->lang->line('ind_erro_requisicao_js'),
            '__TRANS_BIN_LADO_ESQUERDO__'=>$this->lang->line('ind_binario_lado_esquerdo'),
            '__TRANS_BIN_LADO_DIREITO__'=>$this->lang->line('ind_binario_lado_direito'),
            '__TRANS_TUDO_CERTO__'=>$this->lang->line('ind_tudo_certo_js'),
            '__TRANS_CHAVE_BINARIA_OK__'=>$this->lang->line('ind_chave_binaria_alterada_ok')
        );

        $data['rotas'] = MinhasRotas();
        $data['matriz'] = $this->IndicadosModel->MyBinaryNetwork();

        if($checkIsSearch){
            $data['redeHabilitada'] = 0;
        }

        if($this->input->get('patrocinador')){

            $usuarioRede = $this->IndicadosModel->ProcuraUsuarioNaRede($this->input->get('patrocinador'));

            if(!$usuarioRede){
                $data['redeHabilitada'] = 0;
            }
        }
        
		$this->template->load('cliente/template', 'binario', $data);
	}
}
