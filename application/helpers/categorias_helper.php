<?php
function MeiosDisponiveisSaque(){

    $_this =& get_instance();

    $meios = array(
        1=>$_this->lang->line('helper_bankon'),
        2=>$_this->lang->line('helper_newpay'),
        3=>$_this->lang->line('helper_conta_bancaria'),
        4=>$_this->lang->line('helper_carteira_bitcoin'),
        5=>$_this->lang->line('helper_pix'),
        6=>$_this->lang->line('helper_simplepay')
    );

    return $meios;
}

function TiposDisponiveis(){

    $_this =& get_instance();

    $tipos = array(
        1=>$_this->lang->line('helper_entrada'),
        2=>$_this->lang->line('helper_saida')
    );

    return $tipos;
}

function CategoriasDisponiveis(){

    $_this =& get_instance();

    $categorias = array(
        1=>$_this->lang->line('helper_rendimento'),
        2=>$_this->lang->line('helper_rede'),
        3=>$_this->lang->line('helper_raiz')
    );

    return $categorias;
}

function CryptosCoinpayments(){

    $cryptos = array(
        'BTC'=>'Bitcoin (BTC)',
        'ETH'=>'Ethereum (ETH)',
        'LTC'=>'Litecoin (LTC)',
        'DOGE'=>'DogeCoin (DOGE)',
        'DASH'=>'Dash (DASH)',
        'XMR'=>'Monero (XMR)',
        'XRP'=>'Ripple (XRP)',
        'BCH'=>'Bitcoin Cash (BCH)',
        'BNB'=>'BNB Coin (BNB)',
        'QASH'=>'QASH (QASH)',
        'QTUM'=>'Qtum (QTUM)',
        'TRX'=>'Tron (TRX)',
        'TUSD'=>'TrueUSD (TUSD)',
        'USDT'=>'Tether USD (USDT)',
        'ZEC'=>'ZCash (ZEC)'
    );

    return $cryptos;
}

function TiposCadastro(){

    $_this =& get_instance();

    $tipo = array(
        '1'=>'Soy peruano',
        '2'=>$_this->lang->line('helper_sou_estrangeiro'),
    );

    return $tipo;
}

function CategoriasEncryptSMTP(){

    $tipo = array(
        'tls'=>'TLS',
        'ssl'=>'SSL',
    );

    return $tipo;
}


function CategoriasChavesBinarias(){

    $_this =& get_instance();

    $chave = array(
        '1'=>$_this->lang->line('helper_esquerdo'),
        '2'=>$_this->lang->line('helper_direito'),
    );

    return $chave;
}

function CategoriaStatusSaque(){

    $_this =& get_instance();

    $chave = array(
        '0'=>$_this->lang->line('helper_pendente'),
        '1'=>$_this->lang->line('helper_pago'),
        '2'=>$_this->lang->line('helper_estornado'),
    );

    return $chave;
}

function TwilioCategoriasPaginas(){

    $categorias = array(
        'cadastro'=>'Novo Cadastro',
        'recebimento_rendimento'=>'Recebimento de Rendimento',
        'recebimento_rede'=>'Recebimento de Rede',
        'cadastro_rede'=>'Novo cadastro na Rede',
        'comprovante_ativado'=>'Comprovante Ativado',
        'comprovante_rejeitado'=>'Comprovante Rejeitado',
        'saque_pago'=>'Saque Pago',
        'saque_estornado'=>'Saque Estornado',
        'plano_finalizado'=>'Expirar Plano'
    );
    
    return $categorias;
}

function LadoChaveBinaria($chave){

    $chaves = CategoriasChavesBinarias();
    
    foreach($chaves as $chaveValue=>$chaveName){
        
        if($chaveValue == $chave){

            return $chaveName;
        }
    }
}

function StatusSaque($chave){

    $status = CategoriaStatusSaque();
    
    foreach($status as $id=>$value){
        
        if($id == $chave){

            return $value;
        }
    }
}

function TipoCadastro($tipo){

    $tipos = TiposCadastro();

    foreach($tipos as $tipoValue=>$tipoName){

        if($tipoValue == $tipo){

            return $tipoName;
        }
    }

    return false;
}

function CryptoName($crypto){

    $cryptos = CryptosCoinpayments();

    foreach($cryptos as $cryptoValue=>$cryptoName){

        if($cryptoValue == $crypto){

            return $cryptoName;
        }
    }

    return false;
}

function TipoExtrato($tipo){

    $_this =& get_instance();

    switch($tipo){

        case 1:
            $typeName = $_this->lang->line('helper_entrada');
        break;
        
        case 2:
            $typeName = $_this->lang->line('helper_saida');
        break;

        default:
            $typeName = $_this->lang->line('helper_entrada');
        break;
    }

    return $typeName;
}

function CategoriaExtrato($categoria){

    $_this =& get_instance();

    switch($categoria){

        case 1:
            $categoryName = $_this->lang->line('helper_rendimento');
        break;
        
        case 2:
            $categoryName = $_this->lang->line('helper_rede');
        break;

        case 3:
            $categoryName = $_this->lang->line('helper_raiz');
        break;

        default:
            $categoryName = $_this->lang->line('helper_rendimento');
        break;
    }

    return $categoryName;
}

function ColunaContaRecebimento($id_conta){

    switch($id_conta){

        case 1:
            $coluna = 'bankon';
        break;
        
        case 2:
            $coluna = 'newpay';
        break;

        case 3:
            $coluna = 'conta_bancaria';
        break;

        case 4:
            $coluna = 'carteira_bitcoin';
        break;

        case 5:
            $coluna = 'pix';
        break;

        case 6:
            $coluna = 'simplepay';
        break;

        default:
            $coluna = 'bankon';
        break;
    }

    return $coluna;
}

function MeioRecebimento($meio){

    $_this =& get_instance();

    switch($meio){

        case 1:
            $r = $_this->lang->line('form_bankon');
        break;
        
        case 2:
            $r = $_this->lang->line('form_newpay');
        break;

        case 3:
            $r = $_this->lang->line('form_conta_bancaria');
        break;

        case 4:
            $r = $_this->lang->line('form_carteira_bitcoin');
        break;

        case 5:
            $r = $_this->lang->line('form_pix');
        break;

        case 6:
            $r = $_this->lang->line('form_simplepay');
        break;

        default:
            $r = $_this->lang->line('form_bankon');
        break;
    }

    return $r;
}

function MeioRecebimentoNomeCampo($meio){

    $_this =& get_instance();

    switch($meio){

        case 'bankon':
            $r = $_this->lang->line('form_bankon');
        break;
        
        case 'newpay':
            $r = $_this->lang->line('form_newpay');
        break;

        case 'conta_bancaria':
            $r = $_this->lang->line('form_conta_bancaria');
        break;

        case 'carteira_bitcoin':
            $r = $_this->lang->line('form_carteira_bitcoin');
        break;

        case 'pix':
            $r = $_this->lang->line('form_pix');
        break;

        case 'simplepay':
            $r = $_this->lang->line('form_simplepay');
        break;

        default:
            $r = $_this->lang->line('form_bankon');
        break;
    }

    return $r;
}

function MeuSexo($sexo){

    $_this =& get_instance();

    switch($sexo){

        case 1:
            $s = $_this->lang->line('c_f_s_masculino');
        break;
        
        case 2:
            $s = $_this->lang->line('c_f_s_feminino');
        break;

        default:
            $s = $_this->lang->line('c_f_s_nao_informar');
        break;
    }

    return $s;
}

function DDIs(){

    $_this =& get_instance();

    $_this->db->order_by('name', 'ASC');
    $query = $_this->db->get('DDI');

    return $query->result();
}

function TiposPermissao(){

    return
    array(
        'MENUS'=>array(
            'usuarios'=>'Menu Completo de Usuários',
            'usuarios.todos'=>'Somente Todos Usuários',
            'usuarios.ativos'=>'Somente Usuários Ativos',
            'usuarios.pendentes'=>'Somente Usuários Pendentes',
            'faturas'=>'Menu Completo de Faturas',
            'faturas.todas'=>'Somente Todas Faturas',
            'faturas.pendentes'=>'Somente Faturas Pendentes',
            'faturas.ativas'=>'Somente Faturas Ativas',
            'faturas.expiradas'=>'Somente Faturas Expiradas',
            'comprovantes'=>'Menu Completo de Comprovantes',
            'comprovantes.todos'=>'Somente Todos Comprovantes',
            'comprovantes.pendentes'=>'Somente Comprovantes Pendentes',
            'comprovantes.aprovados'=>'Somente Comprovantes Aprovados',
            'comprovantes.rejeitados'=>'Somente Comprovantes Rejeitados',
            'saques'=>'Menu Completo de Saques',
            'saques.todos'=>'Somente Todos os Saques',
            'saques.pendentes'=>'Somente Saques Pendentes',
            'saques.pagos'=>'Somente Saques Pagos',
            'saques.estornados'=>'Somente Saques Estornados',
            'caixa'=>'Menu Completo do Caixa',
            'configuracoes'=>'Menu Completo de Configurações',
            'configuracoes.pacotes'=>'Somente Configurações de Pacotes',
            'configuracoes.contas_bancarias'=>'Somente Configurações Bancárias',
            'configuracoes.grupos'=>'Somente Configurações de Grupos',
            'configuracoes.site'=>'Somente Configurações do Site',
            'configuracoes.saque'=>'Somente Configurações de Saque',
            'configuracoes.rotas'=>'Somente Configurações de Rotas',
            'configuracoes.pix'=>'Somente Configurações de Pix',
            'configuracoes.twillio'=>'Somente Configurações do Twillio',
            'configuracoes.asaas'=>'Somente Configurações Asaas',
            'configuracoes.bankon'=>'Somente Configurações BankOn',
            'configuracoes.simplepay'=>'Somente Configurações SimplePay',
            'configuracoes.coinpayments'=>'Somente Configurações CoinPayments',
            'configuracoes.recaptcha'=>'Somente Configurações Recaptcha',
            'configuracoes.telegram'=>'Somente Configurações do Telegram'
        ),
        'DASHBOARD'=>array(
            'dashboard.entradas_totais'=>'Bloco Entradas Totais',
            'dashboard.saidas_totais'=>'Bloco Saída Totais',
            'dashboard.usuarios_cadastrados'=>'Bloco Usuários Cadastrados',
            'dashboard.usuarios_ativos'=>'Bloco Usuários Ativos',
            'dashboard.saques_pendentes'=>'Bloco Saques Pendentes',
            'dashboard.saques_pagos'=>'Bloco Saques Pagos',
            'dashboard.faturas_ativas'=>'Bloco Faturas Ativas',
            'dashboard.faturas_aberto'=>'Bloco Faturas em Aberto',
            'dashboard.analise_financeira'=>'Gráfico de Análise Financeira',
            'dashboard.saques_plataforma'=>'Bloco Saques por Plataforma',
            'dashboard.top_lideres'=>'Bloco Top Líderes',
            'dashboard.logs'=>'Bloco Últimas Atividades (Logs)',
            'dashboard.ultimos_saques'=>'Bloco Últimos Saques'
        ),
        'USUÁRIOS'=>array(
            'usuarios.visualizar'=>'Somente Visualizar Usuário',
            'usuarios.backoffice'=>'Somente Logar no Backoffice',
            'usuarios.editar'=>'Somente Editar Usuário',
            'usuarios.excluir'=>'Somente Excluir Usuário'
        ),
        'FATURAS'=>array(
            'faturas.normalmente'=>'Somente Ativar Normalmente',
            'faturas.cortesia'=>'Somente Ativar Cortesia',
            'faturas.excluir'=>'Somente Excluir Faturas'
        ),
        'COMPROVANTES'=>array(
            'comprovantes.ativar'=>'Somente Ativar Comprovante',
            'comprovantes.rejeitar'=>'Somente Rejeitar Comprovante',
            'comprovantes.excluir'=>'Somente Excluir Comprovante'
        ),
        'SAQUES'=>array(
            'saques.visualizar'=>'Somente Visualizar Saque',
            'saques.baixa'=>'Somente Dar Baixa do Saque',
            'saques.estornar'=>'Somente Estornar Saque',
            'saques.excluir'=>'Somente Excluir Saque'
        ),
        'CAIXA'=>array(
            'caixa.adicionar'=>'Somente Adicionar no Caixa'
        ),
        'RELATÓRIOS'=>array(
            'relatorios'=>'Visualizar Gráficos'
        ),
    );
}