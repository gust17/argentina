<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contas extends MY_Controller {

    public function __construct(){
        parent::__construct();
        isLogged();
        CheckSystemMaintenance();

        $this->load->model('contasmodel', 'ContasModel');
    }

	public function bancaria(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = $this->lang->line('con_bancaria_titulo');

        $data['jsLoader'] = array(
            'assets/plugins/maskedinput/jquery.maskedinput.min.js',
            'assets/pages/js/contas.js'
        );

        if($this->input->post('submit')){
            $data['message'] = $this->ContasModel->AtualizarContaBancaria();
        }

        $data['conta'] = $this->ContasModel->MinhaContaBancaria();

		$this->template->load('cliente/template', 'bancaria', $data);
    }
    
    public function bankon(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = $this->lang->line('con_bankon_titulo');

        if($this->input->post('submit')){
            $data['message'] = $this->ContasModel->AtualizarBankOn();
        }

        $data['bankon'] = $this->ContasModel->MinhaBankOn();

		$this->template->load('cliente/template', 'bankon', $data);
    }

    // public function simplepay(){

    //     CheckInitializeRoutes(__FUNCTION__, __CLASS__);

    //     $data['nome_pagina'] = $this->lang->line('con_simplepay_titulo');

    //     if($this->input->post('submit')){
    //         $data['message'] = $this->ContasModel->AtualizarSimplePay();
    //     }

    //     $data['simplepay'] = $this->ContasModel->MinhaSimplePay();

	// 	$this->template->load('cliente/template', 'simplepay', $data);
    // }

    public function newpay(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = $this->lang->line('con_newpay_titulo');

        if($this->input->post('submit')){
            $data['message'] = $this->ContasModel->AtualizarNewpay();
        }

        $data['newpay'] = $this->ContasModel->MinhaNewpay();

		$this->template->load('cliente/template', 'newpay', $data);
    }
    
    public function bitcoin(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = $this->lang->line('con_bitcoin_titulo');

        if($this->input->post('submit')){
            $data['message'] = $this->ContasModel->AtualizarCarteiraBitcoin();
        }

        $data['bitcoin'] = $this->ContasModel->MinhaCarteiraBitcoin();

		$this->template->load('cliente/template', 'bitcoin', $data);
    }
    
    public function pix(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);


        //var_dump('aqui');
        $data['nome_pagina'] = $this->lang->line('con_pix_titulo');

        if($this->input->post('submit')){
            $data['message'] = $this->ContasModel->AtualizarPix();
        }

        $data['pix'] = $this->ContasModel->MinhaChavePix();

		$this->template->load('cliente/template', 'pix', $data);
	}
}
