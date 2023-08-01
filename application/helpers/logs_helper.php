<?php
function CreateLog($id_user, $message, $admin = false)
{

    $_this = &get_instance();

    $_this->load->library('user_agent');

    $add = '<br /><small>' . $_this->agent->agent_string() . '</small>';

    if ($admin) {
        $tabela = 'admin_logs';
    } else {
        $tabela = 'usuarios_logs';
    }

    $_this->db->insert($tabela, array(
        'id_usuario' => $id_user,
        'log' => $message . $add,
        'ip' => $_this->input->ip_address(),
        'data_criacao' => date('Y-m-d H:i:s')
    ));
}

function CreateLogSystem($message)
{

    $_this = &get_instance();

    $_this->load->library('user_agent');

    $add = '<br /><small>' . $_this->agent->agent_string() . '</small>';

    $_this->db->insert('logs_sistema', array(
        'log' => $message . $add,
        'ip' => $_this->input->ip_address(),
        'data_criacao' => date('Y-m-d H:i:s')
    ));
}

function CreateNotification($id_user, $message)
{

    $_this = &get_instance();

    $_this->db->insert('notificacoes', array(
        'id_usuario' => $id_user,
        'notificacao' => $message,
        'ip' => $_this->input->ip_address(),
        'data_criacao' => date('Y-m-d H:i:s')
    ));
}

function CreateRegisterBox($id_user = null, $message = '', $type = 1, $value = 0)
{

    $_this = &get_instance();

    $_this->db->insert('caixa', array(
        'id_usuario_admin' => $id_user,
        'registro' => $message,
        'tipo' => $type,
        'valor' => $value,
        'ip' => $_this->input->ip_address(),
        'data_criacao' => date('Y-m-d H:i:s')
    ));
}
