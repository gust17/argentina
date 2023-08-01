<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('loginmodel', 'LoginModel');
	}

	public function index()
	{

		CheckInitializeRoutes(__FUNCTION__, __CLASS__);

		$data = [];

		$data['redirect'] = ($this->input->get('redirect')) ? ltrim($this->input->get('redirect'), '/') : '';
		$data['rotas'] = MinhasRotas();

		if ($this->input->post('submit')) {

			$data['message'] = $this->LoginModel->FazerLogin();
		}

		$this->load->view('login', $data);
	}
}
