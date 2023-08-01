<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cadastro extends MY_Controller {

	public function __construct(){
		parent::__construct();
		
		$this->load->helper('form');
		$this->load->model('cadastromodel', 'CadastroModel');
    }

	public function index(){

		CheckInitializeRoutes(__FUNCTION__, __CLASS__);

		$data = [];

		$data['patrocinador'] = $this->CadastroModel->MeuPatrocinador();
		$data['ddis'] = DDIs();
		$data['rotas'] = MinhasRotas();

		if($this->input->post('submit')){
			$data['message'] = $this->CadastroModel->RealizarCadastro();
		}

		$this->load->view('cadastro', $data);
	}
}
