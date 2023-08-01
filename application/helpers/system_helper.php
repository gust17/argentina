<?php
function CheckSystemMaintenance()
{

    $_this = &get_instance();

    if (SystemInfo('manutencao') == 1) {

        $id_user = $_this->session->userdata('myuserid');

        $contas_liberadas = SystemInfo('contas_liberadas');


        if (!in_array($id_user, json_decode($contas_liberadas, true))) {

            show_error('Manutenção', 'Site em manutenção', 'error_manutencao', 503);
        }
    }
}
function CheckAcessServer($controller, $function = '')
{

    $_this = &get_instance();

    $ipServer = SystemInfo('ip_servidor');

    if ($controller == 'cron') {

        return true;

        if ($ipServer == $_this->input->ip_address()) {
            return true;
        }

        CreateLogSystem(
            'O CRON tentou executar mas ocorreu erro decorrente a autorização do IP. IP do servidor cadastrado: ' . $ipServer . ' - IP de execução: ' . $_this->input->ip_address()
        );

        return exit('O CRON só pode ser executado internamente pelo servidor.');
    } elseif ($controller == 'ajax') {

        $is_ajax = ('xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? ''));

        if (!$is_ajax) {

            CreateLogSystem(
                'Não foi possível realizar a chamada AJAX da função ' . $function . ' pois foi solicitado fora do jQuery.'
            );

            return exit('O AJAX só pode ser solicitado internamente pelo servidor. (jQuery)');
        } else {

            return true;

            if ($ipServer == $_this->input->ip_address()) {
                return true;
            }

            CreateLogSystem(
                'Não foi possível realizar a chamada AJAX da função ' . $function . ' pois o IP do servidor de acesso é diferente do permitido. IP do servidor cadastrado: ' . $ipServer . ' - IP de execução: ' . $_this->input->ip_address()
            );

            return exit('O AJAX só pode ser solicitado internamente pelo servidor (IP)');
        }
    }
}

function SystemInfo($column)
{

    $config = [];

    $_this = &get_instance();

    $_this->db->limit(1);
    $_this->db->order_by('id', 'ASC');
    $query = $_this->db->get('configuracoes_sistema');

    $row = $query->row();

    $config[$column] = $row->$column;

    return $row->$column;
}

function GenerateCode($size = 15)
{
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuwxyz0123456789";
    $randomString = '';
    for ($i = 0; $i < $size; $i = $i + 1) {
        $randomString .= $chars[mt_rand(0, 60)];
    }
    return $randomString;
}

function InvoiceInfo($id, $column)
{

    $_this = &get_instance();

    $_this->db->where('id', $id);
    $query = $_this->db->get('faturas');

    if ($query->num_rows() > 0) {

        return $query->row()->$column;
    }

    return false;
}

function PlanInfo($id, $column)
{

    $_this = &get_instance();

    $_this->db->where('id', $id);
    $query = $_this->db->get('planos');

    if ($query->num_rows() > 0) {

        return $query->row()->$column;
    }

    return false;
}

function RegisterExtractItem($id_user, $descricao, $valor, $tipo_saldo, $categoria, $referencia = null, $date = null, $codigo_controle = null)
{

    if (is_null($date)) {
        $date = date('Y-m-d H:i:s');
    }

    $_this = &get_instance();

    $dadosExtrato = array(
        'id_usuario' => $id_user,
        'descricao' => $descricao,
        'valor' => $valor,
        'tipo_saldo' => $tipo_saldo,
        'categoria' => $categoria,
        'referencia' => $referencia,
        'data_criacao' => $date,
        'codigo_controle' => $codigo_controle
    );

    if (is_null($codigo_controle)) {

        $_this->db->insert('extrato', $dadosExtrato);
    } else {

        $values = implode('","', array_values($dadosExtrato));

        $valuesFormatted = "(" . implode(',', array_keys($dadosExtrato)) . ") VALUES (" . str_pad($values, strlen($values) + 2, '"', STR_PAD_BOTH) . ")";

        $_this->db->query("INSERT IGNORE INTO extrato " . $valuesFormatted);
    }

    $idExtratoCriado = $_this->db->insert_id();

    return $idExtratoCriado;
}

function PontuacaoScore($level, $referencia)
{

    $_this = &get_instance();

    $_this->db->where('level', $level);
    $_this->db->where('referencia', $referencia);
    $query = $_this->db->get('levels_pontuacoes_score');

    return $query->row()->score;
}

function sanitizeString($str)
{
    $str = preg_replace('/[áàãâä]/ui', 'a', $str);
    $str = preg_replace('/[éèêë]/ui', 'e', $str);
    $str = preg_replace('/[íìîï]/ui', 'i', $str);
    $str = preg_replace('/[óòõôö]/ui', 'o', $str);
    $str = preg_replace('/[úùûü]/ui', 'u', $str);
    $str = preg_replace('/[ç]/ui', 'c', $str);
    $str = preg_replace('/[^a-z0-9]/i', '_', $str);
    $str = preg_replace('/_+/', '_', $str); // ideia do Bacco :)
    return $str;
}

function addCentavos($valor, $id_fatura = 0)
{

    $centavos = substr($id_fatura, -2);
    $centavos = (strlen($centavos) >= 2) ? $centavos : '0' . $centavos;
    $centavos = $centavos / 100;

    $valorPagar = $valor + $centavos;

    return $valorPagar;
}

function documentFormatCNPJ($document)
{

    if (strlen($document) == 14) {
        $document = substr($document, 0, 2) . '.' . substr($document, 2, 3) . '.' . substr($document, 5, 3) . '/' . substr($document, 8, 4) . '-' . substr($document, 12, 2);
    } else {
        $document = substr($document, 0, 3) . '.' . substr($document, 3, 3) . '.' . substr($document, 6, 3) . '/' . substr($document, 9, 4) . '-' . substr($document, 13, 2);
    }

    return $document;
}

function EnviarSMSAdmins($mensagem)
{
}

function ListaTiposChaves()
{

    $tipos = [
        'CPF' => 'CPF',
        'CNPJ' => 'CNPJ',
        'EMAIL' => 'EMAIL',
        'PHONE' => 'CELULAR',
        'EVP' => "CHAVE ALEATÓRIA",
    ];

    return $tipos;
}
