<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permission {

    public $_this;
    public $rotas;

    public function __construct(){

        $this->_this =& get_instance();
        $this->rotas = MinhasRotas();

        $this->userAdmin = $this->_this->session->userdata('admin_myuserid_92310');
    }

    public function setConstPermissions(){

        $this->_this->db->where('id_usuario', $this->userAdmin);
        $this->_this->db->where('status', 0);
        $query = $this->_this->db->get('configuracoes_permissoes');

        if($query->num_rows() > 0){

            foreach($query->result() as $result){

                define('AUTH_'.strtoupper($result->page_block), 'Block');
            }
        }
    }

    public function Authorization($page_block){

        if(defined('AUTH_'.strtoupper($page_block))){

            return false;
        }

        return true;
    }

    public function AuthorizationWithRedirect($page_block){

        $authorization = $this->Authorization($page_block);

        if(!$authorization){

            redirect($this->rotas->admin_nao_autorizado);
            exit;
        }
    }

    public function PermissionSearchUser($id_user){

        $permissions = array();

        $this->_this->db->where('id_usuario', $id_user);
        $query = $this->_this->db->get('configuracoes_permissoes');

        if($query->num_rows() > 0){

            foreach($query->result() as $result){

                $permissions[] = $result->page_block;
            }
        }

        return $permissions;
    }
}