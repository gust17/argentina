<?php if (!defined('BASEPATH')) exit('Direct access allowed');

class Lang extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->userid = $this->session->userdata('myuserid');
    }

    function switch()
    {

        $language = $this->input->get('lang');

        $language = ($language != "") ? $language : "spanish";

        if (!is_dir(APPPATH . 'language/' . $language)) {
            $language = 'spanish';
        }

        if ($language == 'portuguese-br') {
            $flag = 'br';
        } elseif ($language == 'english') {
            $flag = 'uk';
        } else {
            $flag = 'es';
        }

        $this->db->where('id', $this->userid);
        $this->db->update('usuarios_cadastros', array('linguagem_padrao' => $language));

        $this->session->set_userdata('site_lang', $language);
        $this->session->set_userdata('flag_investing', $flag);

        redirect($_SERVER['HTTP_REFERER']);
    }
}
