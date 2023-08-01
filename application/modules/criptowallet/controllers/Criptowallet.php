<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Criptowallet extends MY_Controller {

    public function __construct(){
        parent::__construct();
        isLogged();
        CheckSystemMaintenance();

        $this->load->model('criptowalletmodel', 'CriptowalletModel');
    }

	public function index(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = 'Criptowallet';

        $data['cssLoader'] = array(
            
        );

        $data['jsLoader'] = array(
            
        );

		$this->template->load('cliente/template', 'wallet', $data);
    }
    
}

