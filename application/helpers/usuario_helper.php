<?php

function validaCPF($cpf)
{

    // Extrai somente os números
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);

    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

function isLogged()
{

    $_this = &get_instance();

    $rotas = MinhasRotas();

    $link = uri_string();

    if (!$_this->session->userdata('myuserid')) {

        redirect($rotas->login . '?redirect=/' . $link);
        exit;
    }
}

function isLoggedAdmin()
{

    $_this = &get_instance();

    $rotas = MinhasRotas();

    $link = uri_string();

    if (!$_this->session->userdata('admin_myuserid_92310')) {
        redirect($rotas->admin_login);
        exit;
    }
}

function EnabledMasterKey($show_error = false)
{

    $_this = &get_instance();

    $mk = $_this->session->userdata('mkey_accept_login_admin');

    if ($mk === true) {
        return true;
    } else {
        if (!$show_error) {
            return false;
        }

        show_error('Acesso não permitido', 403, 'error_not_permited');
        exit;
    }
}

function UserInfo($column = 'id', $id = null)
{

    $configList = [];

    $_this = &get_instance();

    if (!is_null($id)) {
        $id = $id;
    } else {
        $id = $_this->session->userdata('myuserid');
    }

    $_this->db->where('id', $id);
    $query = $_this->db->get('usuarios_cadastros');

    if ($query->num_rows() > 0) {

        $row = $query->row();

        $configList[$column] = $row->$column;

        return $row->$column;
    }

    return false;
}

function PerfilUsuario($id)
{

    $_this = &get_instance();

    return '<img src="' . base_url('assets/cliente/default/assets/images/icons/64px/' . $id . '.svg') . '" width="16" height="16" alt="" class="img-fluid"> Investidor(a)';
}

function AvatarLoad($id_usuario = false)
{

    $_this = &get_instance();

    if (!$id_usuario) {
        $id_usuario = $_this->session->userdata('myuserid');
    }

    $avatar = UserInfo('avatar', $id_usuario);
    $sexo = UserInfo('sexo', $id_usuario);

    if (is_null($avatar) || empty($avatar)) {

        if ($sexo == 1) {
            $icon = 1;
        } elseif ($sexo == 2) {
            $icon = 2;
        } else {
            $icon = 3;
        }

        $avatar = 'assets/pages/img/avatar-' . $icon . '.png';
    }

    return base_url($avatar);
}

function ConsultarDocumento($documento, $data_nascimento)
{

    $documento = str_replace(array('-', '.', '/'), array('', '', ''), trim($documento));

    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
            CURLOPT_URL => "https://ws.hubdodesenvolvedor.com.br/v2/cpf/?cpf=" . $documento . "&data=&token=117567595mzFwqeMdLh212264728",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        )
    );
    $resultado = curl_exec($ch);
    if (@curl_errno($ch)) {

        return false;
    }

    curl_close($ch);

    $resultado = json_decode($resultado);

    if ($resultado->return == 'OK') {

        if ($resultado->result->data_nascimento == $data_nascimento) {
            return true;
        }
    }

    return false;
}

function checkNPS($userid)
{

    return (UserInfo('nps') == 1) ? true : false;
}
