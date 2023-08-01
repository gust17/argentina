<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recuperar extends MY_Controller {

	public function __construct(){
		parent::__construct();
		
		$this->load->model('recuperarmodel', 'RecuperarModel');
    }

	public function index(){

		CheckInitializeRoutes(__FUNCTION__, __CLASS__);

		$data = [];

		$data['rotas'] = MinhasRotas();

		if($this->input->post('submit')){
			$data['message'] = $this->RecuperarModel->EnviarLink();
		}

		$this->load->view('recuperar', $data);
	}

	public function trocar($codigo){

		CheckInitializeRoutes(__FUNCTION__, __CLASS__);

		$data['rotas'] = MinhasRotas();

		if(!$this->input->post('submit')){
			$data['checkCode'] = $this->RecuperarModel->CheckValidCode($codigo);
		}

		if($this->input->post('submit')){
			$data['message'] = $this->RecuperarModel->TrocarSenha($codigo);
		}

		$this->load->view('trocar', $data);
	}
}
