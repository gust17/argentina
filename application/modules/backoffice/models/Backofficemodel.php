<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Backofficemodel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

        $this->userid = $this->session->userdata('myuserid');
    }

    public function RSS()
    {

        $this->load->library('rssparser');

        $this->rssparser->set_feed_url($this->lang->line('link_rss'));
        $this->rssparser->set_aleatory(TRUE);
        $rss = $this->rssparser->getFeed(1);

        return $rss;
    }

    public function InvestimentosDisponiveis()
    {

        $score = UserInfo('score');

        $this->db->where('score_necessario <= ', $score);
        $query = $this->db->get('planos');

        return $query->num_rows();
    }

    public function TotalPlanosSistema()
    {

        $this->db->where('exibir', 1);
        $query = $this->db->get('planos');

        return $query->num_rows();
    }

    public function Logout()
    {

        $rotas = MinhasRotas();

        $this->session->unset_userdata('myuserid');

        redirect($rotas->login);
    }
}
