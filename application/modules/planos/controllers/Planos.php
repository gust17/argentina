<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Planos extends MY_Controller {

    public function __construct(){
        parent::__construct();
        isLogged();
        CheckSystemMaintenance();

        $this->load->model('planosmodel', 'PlanosModel');
    }

	public function comprar(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = $this->lang->line('plan_comprar_titulo');

        $data['cssLoader'] = array(
            'assets/pages/css/plans.css'
        );

        $data['jsLoader'] = array(
            'node_modules/atropos/atropos.js',
            'assets/pages/js/planos.js'
        );

        if($this->input->post('submit')){
            $data['message'] = $this->PlanosModel->GerarFatura();
        }

        $data['planos1'] = $this->PlanosModel->TodosPlanos(1);
        $data['planos2'] = $this->PlanosModel->TodosPlanos(2);
        $data['planos3'] = $this->PlanosModel->TodosPlanos(3);
        $data['planos4'] = $this->PlanosModel->TodosPlanos(4);
        
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['score'] = UserInfo('score');

		$this->template->load('cliente/template', 'comprar', $data);
    }
    
    public function ativos(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = $this->lang->line('plan_ativos_titulo');

        $data['rotas'] = MinhasRotas();
        $data['planos'] = $this->PlanosModel->ListarPlanos(1);
        $data['cancelamento_contrato'] = SystemInfo('cancelamento_contrato');
        $data['paga_raiz_rendimento'] = SystemInfo('pagamento_raiz');

		$this->template->load('cliente/template', 'ativos', $data);
    }
    
    public function expirados(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);
        
        $data['nome_pagina'] = $this->lang->line('plan_expirados_titulo');

        $data['jsLoader'] = array(
            'assets/pages/js/planos.js'
        );

        $data['jsVar'] = array(
            '__TRANS_RENOVAR_CONTRATO_TITLE__'=>$this->lang->line('plan_renovation_title_js'),
            '__TRANS_RENOVAR_CONTRATO_DESC__'=>$this->lang->line('plan_renovation_desc_js'),
            '__TRANS_RENOVAR_CONTRATO_CANCEL__'=>$this->lang->line('plan_renovation_button_cancel_js'),
            '__TRANS_RENOVAR_CONTRATO_CONFIRM__'=>$this->lang->line('plan_renovation_button_confirm_js'),
            '__TRANS_RENOVAR_OK__'=>$this->lang->line('plan_renovation_ok_js'),
            '__TRANS_RENOVAR_ERRO__'=>$this->lang->line('plan_renovation_erro_js'),
            '__TRANS_SUCESSO__'=>$this->lang->line('sucesso'),
            '__TRANS_ERRO__'=>$this->lang->line('erro')
        );
        
        $data['rotas'] = MinhasRotas();
        $data['planos'] = $this->PlanosModel->ListarPlanos(2);
        $data['paga_raiz_rendimento'] = SystemInfo('pagamento_raiz');

		$this->template->load('cliente/template', 'expirados', $data);
	}
}
