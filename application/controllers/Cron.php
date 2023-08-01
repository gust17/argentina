<?php
class Cron extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        // CheckAcessServer('cron');

        $this->load->model('cronmodel', 'Cron');
    }

    public function pay_bonification()
    {

        echo $this->Cron->payBonification();
    }

    public function pay_salary_unilevel_user()
    {

        echo $this->Cron->PaySalary();
    }

    public function change_profile()
    {

        echo $this->Cron->changeProfile();
    }

    public function check_pix()
    {

        echo $this->Cron->CheckPix();
    }

    public function score_check_frequence()
    {

        echo $this->Cron->CheckFrequence();
    }

    public function score_check_clicks_link()
    {

        echo $this->Cron->CheckCLicksLink();
    }

    public function score_check_buy_plans()
    {

        echo $this->Cron->CheckBuyPlan();
    }

    public function score_check_address()
    {

        echo $this->Cron->CheckAddressProfile();
    }

    public function clear_redis()
    {

        echo $this->Cron->ClearRedis();
    }

    public function pay_withdraws()
    {

        echo $this->Cron->PayWithdraws();
    }
}
