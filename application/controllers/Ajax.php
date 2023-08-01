<?php
class Ajax extends MY_Controller{

    public function __construct(){
        parent::__construct();

        $this->load->model('ajaxmodel', 'AjaxModel');
    }

    public function consultar_documento(){

        // CheckAcessServer('ajax', __FUNCTION__);

        echo $this->AjaxModel->ConsultarDocumento();
    }

    public function envio_codigo_saque(){

        echo $this->AjaxModel->EnviaCodigoSaque();
    }

    public function push_unsubscriber(){

        CheckAcessServer('ajax', __FUNCTION__);

        echo $this->AjaxModel->PushAlertUnsubscriber();
    }

    public function push_subscriber(){

        CheckAcessServer('ajax', __FUNCTION__);

        echo $this->AjaxModel->PushAlertSubscriber();
    }

    public function renovation_contract(){

        CheckAcessServer('ajax', __FUNCTION__);

        echo $this->AjaxModel->RenovationContract();
    }

    public function save_key_binary(){

        CheckAcessServer('ajax', __FUNCTION__);

        echo $this->AjaxModel->ChangeBinaryKey();
    }

    public function show_affiliate_network(){

        CheckAcessServer('ajax', __FUNCTION__);

        echo $this->AjaxModel->ShowInfoAffiliate();
    }

    public function generate_new_wallet(){

        CheckAcessServer('ajax', __FUNCTION__);

        $crypto = $this->input->post('crypto', true);

        echo $this->AjaxModel->GenerateNewWallet(strtoupper($crypto));
    }

    public function send_satisfaction(){

        echo $this->AjaxModel->EnviarPesquisa();
    }

    public function admin_dashboard_finance(){

        CheckAcessServer('ajax', __FUNCTION__);

        echo $this->AjaxModel->AdminGraphIncomeAndExits(7);
    }

    public function admin_user_extract_delete(){

        CheckAcessServer('ajax', __FUNCTION__);

        echo $this->AjaxModel->DeleteExtract();
    }

    public function admin_user_extract_add(){

        CheckAcessServer('ajax', __FUNCTION__);

        echo $this->AjaxModel->AddExtract();
    }

    public function admin_user_extract_edit(){

        CheckAcessServer('ajax', __FUNCTION__);

        $action = $this->input->post('action');

        if($action == 'info'){

            echo $this->AjaxModel->InfoExtract();

        }else{

            echo $this->AjaxModel->SaveExtract();
        }
    }

    public function admin_user_fatura_edit(){

        CheckAcessServer('ajax', __FUNCTION__);

        $action = $this->input->post('action');

        if($action == 'info'){

            echo $this->AjaxModel->InfoInvoice();

        }else{

            echo $this->AjaxModel->SaveInvoice();
        }
    }

    public function admin_user_code_delete(){

        CheckAcessServer('ajax', __FUNCTION__);

        echo $this->AjaxModel->DeleteCode();
    }

    public function admin_user_create_authy(){

        CheckAcessServer('ajax', __FUNCTION__);

        echo $this->AjaxModel->CreateUserAuthy();
    }

    public function admin_see_receipt(){

        CheckAcessServer('ajax', __FUNCTION__);

        echo $this->AjaxModel->SeeReceiptLog();
    }

    public function admin_relatorio_planos_investidos(){

        CheckAcessServer('ajax', __FUNCTION__);

        echo $this->AjaxModel->RelatorioPlanosInvestidos();
    }

    public function admin_relatorio_meios_pagamentos(){

        CheckAcessServer('ajax', __FUNCTION__);

        echo $this->AjaxModel->RelatorioMeiosInvestidos();
    }

    public function admin_relatorio_retirada_meio(){

        CheckAcessServer('ajax', __FUNCTION__);

        echo $this->AjaxModel->RelatorioRetiradaMeio();
    }

    public function admin_relatorio_dias_retirada(){

        CheckAcessServer('ajax', __FUNCTION__);

        echo $this->AjaxModel->RelatorioSaquesDia();
    }
}