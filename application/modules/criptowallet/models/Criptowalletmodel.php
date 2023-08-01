<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Criptowalletmodel extends CI_Model {

    public function __construct(){
        parent::__construct();

        $this->userid = $this->session->userdata('myuserid');
    }
}

