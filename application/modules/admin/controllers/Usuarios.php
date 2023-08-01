<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends MY_Controller {

    public function __construct(){
        parent::__construct();
        
        isLoggedAdmin();

        $this->permission->AuthorizationWithRedirect('usuarios');
        
        $this->load->model('usuariosmodel', 'UsuariosModel');
        $this->load->model('planos/planosmodel', 'PlanosModel');
    }

	public function index(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('usuarios.todos');

        $data['nome_pagina'] = 'Lista de Usuários completos';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js'
        );
        
        $data['usuarios'] = $this->UsuariosModel->TodosUsuarios();

        $data['permitidoVisualizar'] = $this->permission->Authorization('usuarios.visualizar');
        $data['permitidoBackoffice'] = $this->permission->Authorization('usuarios.backoffice');
        $data['permitidoEditar'] = $this->permission->Authorization('usuarios.editar');
        $data['permitidoExcluir'] = $this->permission->Authorization('usuarios.excluir');

		$this->template->load('admin/template', 'usuarios/usuarios', $data);
    }

    public function ativos(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('usuarios.ativos');

        $data['nome_pagina'] = 'Lista de Usuários Ativos';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js'
        );

        $data['usuarios'] = $this->UsuariosModel->TodosUsuarios(1);

        $data['permitidoVisualizar'] = $this->permission->Authorization('usuarios.visualizar');
        $data['permitidoBackoffice'] = $this->permission->Authorization('usuarios.backoffice');
        $data['permitidoEditar'] = $this->permission->Authorization('usuarios.editar');
        $data['permitidoExcluir'] = $this->permission->Authorization('usuarios.excluir');

		$this->template->load('admin/template', 'usuarios/usuarios', $data);
    }

    public function pendentes(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('usuarios.pendentes');

        $data['nome_pagina'] = 'Lista de Usuários Pendentes';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js'
        );

        $data['usuarios'] = $this->UsuariosModel->TodosUsuarios(0);

        $data['permitidoVisualizar'] = $this->permission->Authorization('usuarios.visualizar');
        $data['permitidoBackoffice'] = $this->permission->Authorization('usuarios.backoffice');
        $data['permitidoEditar'] = $this->permission->Authorization('usuarios.editar');
        $data['permitidoExcluir'] = $this->permission->Authorization('usuarios.excluir');

		$this->template->load('admin/template', 'usuarios/usuarios', $data);
    }

    public function administrativos(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('usuarios.administrativos');

        $data['nome_pagina'] = 'Lista de Usuários Administrativos';

        $data['rotas'] = MinhasRotas();

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js'
        );

        $data['usuarios'] = $this->UsuariosModel->TodosUsuarios(false, true);

        $data['permitidoVisualizar'] = $this->permission->Authorization('usuarios.visualizar');
        $data['permitidoBackoffice'] = $this->permission->Authorization('usuarios.backoffice');
        $data['permitidoEditar'] = $this->permission->Authorization('usuarios.editar');
        $data['permitidoExcluir'] = $this->permission->Authorization('usuarios.excluir');

		$this->template->load('admin/template', 'usuarios/usuarios', $data);
    }

    public function visualizar($id){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);

        $this->permission->AuthorizationWithRedirect('usuarios.visualizar');

        $data['nome_pagina'] = 'Visualizar Usuário';

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js'
        );

        $data['rotas'] = MinhasRotas();
        $data['dias_pagamento_saque'] = SystemInfo('dias_uteis_pagamento_saque');
        $data['usuario'] = $this->UsuariosModel->DadosUsuario($id);
        $data['rede'] = $this->UsuariosModel->RedeUsuario($id);
        $data['transacoes'] = $this->UsuariosModel->ExtratoUsuario($id);
        $data['faturas'] = $this->UsuariosModel->FaturasUsuario($id);
        $data['saques'] = $this->UsuariosModel->SaquesUsuario($id);
        $data['notificacoes'] = $this->UsuariosModel->NotificacoesUsuario($id);
        $data['codigos_bankon'] = $this->UsuariosModel->CodigosBankonUsuario($id);
        $data['logs'] = $this->UsuariosModel->LogsUsuario($id);
        $data['idUser'] = $id;

		$this->template->load('admin/template', 'usuarios/visualizar', $data);
    }

    public function editar($id){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);
        EnabledMasterKey(true);

        $this->permission->AuthorizationWithRedirect('usuarios.editar');

        $data['nome_pagina'] = 'Editar Usuário';

        $data['cssLoader'] = array(
            'assets/plugins/datatables/dataTables.bootstrap4.min.css',
            'assets/admin/assets/libs/sweetalert2/sweetalert2.min.css',
            'assets/cliente/default/assets/css/plugins/select2.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js',
            'assets/plugins/maskedinput/jquery.maskedinput.min.js',
            'assets/plugins/maskmoney/jquery.maskMoney.min.js',
            'assets/admin/assets/libs/sweetalert2/sweetalert2.min.js',
            'assets/cliente/default/assets/js/plugins/select2.full.min.js',
            'assets/pages/js/admin/usuarios.js'
        );

        if($this->input->post('submitDados')){
            $data['message'] = $this->UsuariosModel->AtualizarDados($id);
        }

        if($this->input->post('submitRede')){
            $data['message'] = $this->UsuariosModel->AtualizarRede($id);
        }

        if($this->input->post('submitContas')){
            $data['message'] = $this->UsuariosModel->AtualizarContas($id);
        }

        if($this->input->post('submitAdmin')){
            $data['message'] = $this->UsuariosModel->AtualizarAdmin($id);
        }

        $data['dias_pagamento_saque'] = SystemInfo('dias_uteis_pagamento_saque');
        $data['usuario'] = $this->UsuariosModel->DadosUsuario($id);
        $data['rede'] = $this->UsuariosModel->RedeUsuario($id);
        $data['transacoes'] = $this->UsuariosModel->ExtratoUsuario($id);
        $data['faturas'] = $this->UsuariosModel->FaturasUsuario($id);
        $data['lista_bancos'] = ListaBancos();
        $data['tipos_disponiveis'] = TiposDisponiveis();
        $data['categorias_disponiveis'] = CategoriasDisponiveis();
        $data['planos'] = $this->PlanosModel->TodosPlanos();
        $data['codigos_bankon'] = $this->UsuariosModel->CodigosBankonUsuario($id);
        $data['allPermission'] = $this->permission->PermissionSearchUser($id);
        $data['ddis'] = DDIs();

		$this->template->load('admin/template', 'usuarios/editar', $data);
    }

    public function excluir($id){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);
        EnabledMasterKey(true);

        $this->permission->AuthorizationWithRedirect('usuarios.excluir');

        $this->UsuariosModel->ExcluirUsuario($id);
    }

    public function backoffice($id){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__, true);
        EnabledMasterKey(true);

        $this->permission->AuthorizationWithRedirect('usuarios.backoffice');

        $this->UsuariosModel->Backoffice($id);
    }
}
