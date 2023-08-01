<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil extends MY_Controller {

    public function __construct(){
        parent::__construct();
        isLogged();
        CheckSystemMaintenance();

        $this->load->model('perfilmodel', 'PerfilModel');
    }

	public function dados(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = $this->lang->line('perf_meus_dados_titulo');

        $data['jsLoader'] = array(
            'assets/plugins/maskedinput/jquery.maskedinput.min.js',
            'assets/pages/js/perfil.js'
        );

        if($this->input->post('submit')){
            $data['message'] = $this->PerfilModel->AtualizarDadosPessoais();
        }

        $data['dados'] = $this->PerfilModel->MeusDadosPessoais();
        $data['ddis'] = $this->PerfilModel->DDI();

		$this->template->load('cliente/template', 'dados', $data);
    }
    
    public function senha(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = $this->lang->line('perf_senha_titulo');

        if($this->input->post('submit')){
            $data['message'] = $this->PerfilModel->AtualizarSenha();
        }

		$this->template->load('cliente/template', 'senha', $data);
	}
}
