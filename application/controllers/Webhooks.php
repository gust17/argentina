<?php
class Webhooks extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('webhooksmodel', 'WebhooksModel');
    }

    public function coinpayments()
    {

        echo $this->WebhooksModel->ActiveAccountCoinPayments();
    }

    public function asaas()
    {

        echo $this->WebhooksModel->ActiveAccountAsaas();
    }
}
