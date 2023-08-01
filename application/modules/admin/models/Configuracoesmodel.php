<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Configuracoesmodel extends CI_Model
{

    protected $rotas;
    protected $userid;

    public function __construct()
    {
        parent::__construct();

        $this->rotas = MinhasRotas();

        $this->userid = $this->session->userdata('admin_myuserid_92310');

        $this->load->library('upload');
    }

    public function EditarSite()
    {

        $nome_site = $this->input->post('nome_site', true);
        $descricao_site = $this->input->post('descricao_site', true);
        $google_analytics = $this->input->post('google_analytics');
        $codigo_patrocinio_padrao = $this->input->post('codigo_patrocinio_padrao', true);
        $quantidade_planos = $this->input->post('quantidade_planos', true);
        $niveis_unilevel = $this->input->post('niveis_unilevel', true);
        $faturas_cortesia_label = $this->input->post('faturas_cortesia_label', true);
        $moeda_formato = $this->input->post('moeda_formato', true);
        $query_string_patrocinador = $this->input->post('query_string_patrocinador', true);
        $modal_backoffice_status = $this->input->post('modal_backoffice_status', true);
        $modal_backoffice_editor = $this->input->post('modal_backoffice_editor', true);

        $update = $this->db->update('configuracoes_sistema', array(
            'nome_site' => $nome_site,
            'descricao_site' => $descricao_site,
            'google_analytics' => $google_analytics,
            'codigo_patrocinio_padrao' => $codigo_patrocinio_padrao,
            'quantidade_planos' => $quantidade_planos,
            'niveis_unilevel' => $niveis_unilevel,
            'faturas_cortesia_label' => $faturas_cortesia_label,
            'moeda_formato' => $moeda_formato,
            'query_string_patrocinador' => $query_string_patrocinador,
            'modal_backoffice_status' => $modal_backoffice_status,
            'modal_backoffice_editor' => $modal_backoffice_editor
        ));

        if ($update) {




            CreateLog($this->userid, 'Atualizou as configurações do site.', true);

            return alerts('Configurações salvas com sucesso!', 'success');
        }

        return alerts('Erro ao salvar configurações. Tente novamente', 'danger');
    }

    public function EditarLogos()
    {

        $dataDBUpload = [];

        $config['upload_path'] = 'uploads';
        $config['allowed_types'] = 'svg|svgz|png|jpeg|jpg|bmp|gif';
        $config['encrypt_name'] = true;

        if (isset($_FILES['logo_desktop']['tmp_name']) && !empty($_FILES['logo_desktop']['tmp_name'])) {

            $this->upload->initialize($config);

            if ($this->upload->do_upload('logo_desktop')) {

                $dataUpload = $this->upload->data();

                $fileNameDesktopLogo = $dataUpload['file_name'];

                $dataDBUpload['logo_desktop'] = $config['upload_path'] . '/' . $fileNameDesktopLogo;
            } else {

                return alerts('Não foi possível fazer upload do Logo para Desktop: ' . $this->upload->display_errors(), 'danger');
            }
        }

        if (isset($_FILES['logo_mobile']['tmp_name']) && !empty($_FILES['logo_mobile']['tmp_name'])) {

            $this->upload->initialize($config);

            if ($this->upload->do_upload('logo_mobile')) {

                $dataUpload = $this->upload->data();

                $fileNameMobileLogo = $dataUpload['file_name'];

                $dataDBUpload['logo_mobile'] = $config['upload_path'] . '/' . $fileNameMobileLogo;
            } else {

                return alerts('Não foi possível fazer upload do Logo para Mobile: ' . $this->upload->display_errors(), 'danger');
            }
        }

        if (count($dataDBUpload) > 0) {

            $update = $this->db->update('configuracoes_sistema', $dataDBUpload);

            if ($update) {




                CreateLog($this->userid, 'Atualizou as logos do site.', true);

                return alerts('Logos atualizadas com sucesso!', 'success');
            }

            return alerts('Erro ao atualizar as logos. Tente novamente', 'danger');
        }

        return alerts('Ocorreu um erro desconhecido ao atualizar as logos. Tente novamente ou entre em contato com o T.I', 'danger');
    }

    public function EditarSMTP()
    {

        $smtp_host = $this->input->post('smtp_host', true);
        $smtp_usuario = $this->input->post('smtp_usuario', true);
        $smtp_senha = $this->input->post('smtp_senha', true);
        $smtp_port = $this->input->post('smtp_port', true);
        $smtp_encrypt = $this->input->post('smtp_encrypt', true);

        $update = $this->db->update('configuracoes_sistema', array(
            'smtp_host' => $smtp_host,
            'smtp_usuario' => $smtp_usuario,
            'smtp_senha' => $smtp_senha,
            'smtp_port' => $smtp_port,
            'smtp_encrypt' => $smtp_encrypt
        ));

        if ($update) {




            CreateLog($this->userid, 'Atualizou as configurações de SMTP.', true);

            return alerts('Configurações de SMTP salvas com sucesso!', 'success');
        }

        return alerts('Erro ao salvar configurações de SMTP. Tente novamente', 'danger');
    }

    public function EditarCancelamentoContrato()
    {

        $habilitar_cancelamento = $this->input->post('habilitar_cancelamento', true);
        $taxa_cancelamento = $this->input->post('taxa_cancelamento', true);

        $update = $this->db->update('configuracoes_sistema', array(
            'cancelamento_contrato' => $habilitar_cancelamento,
            'taxa_cancelamento' => $taxa_cancelamento
        ));

        if ($update) {




            CreateLog($this->userid, 'Atualizou as configurações de cancelamento de contrato', true);

            return alerts('Configurações de cancelamento de contrato salvas com sucesso!', 'success');
        }

        return alerts('Erro ao salvar configurações. Tente novamente', 'danger');
    }

    public function EditarServidor()
    {

        $contas = array();

        $ip_servidor = $this->input->post('ip_servidor', true);
        $rendimento_hora = $this->input->post('rendimento_hora', true);
        $manutencao = $this->input->post('manutencao', true);
        $contas_liberadas = $this->input->post('contas_liberadas', true);

        if (is_array($contas_liberadas)) {
            foreach ($contas_liberadas as $account) {
                $contas[] = $account;
            }
        }

        $update = $this->db->update('configuracoes_sistema', array(
            'ip_servidor' => $ip_servidor,
            'rendimento_hora' => $rendimento_hora,
            'manutencao' => $manutencao,
            'contas_liberadas' => json_encode($contas)
        ));

        if ($update) {




            CreateLog($this->userid, 'Atualizou as configurações do servidor.', true);

            return alerts('Configurações do servidor salvas com sucesso!', 'success');
        }

        return alerts('Erro ao salvar configurações. Tente novamente', 'danger');
    }

    public function EditarSaque()
    {

        $meios = array();

        $apos_vencido = $this->input->post('apos_vencido', true);
        $prazo_saque = $this->input->post('prazo_saque', true);
        $prazo_urgencia = $this->input->post('prazo_urgencia', true);
        $meio_disponiveis = $this->input->post('meio_disponiveis', true);
        $saque_liberado = $this->input->post('saque_liberado', true);

        $meiosDatabase = json_decode(SystemInfo('meios_disponiveis_saque'), true);

        foreach ($meiosDatabase as $meioName => $meioValue) {

            if (isset($meio_disponiveis[$meioName])) {
                $meios[$meioName] = true;
            } else {
                $meios[$meioName] = false;
            }
        }

        $update = $this->db->update('configuracoes_sistema', array(
            'sacar_rendimento_apos_vencido' => $apos_vencido,
            'dias_uteis_pagamento_saque' => $prazo_saque,
            'prazo_saque_urgencia' => $prazo_urgencia,
            'meios_disponiveis_saque' => json_encode($meios),
            'saque_liberado' => $saque_liberado
        ));

        if ($update) {




            CreateLog($this->userid, 'Atualizou as configurações de Saque Geral.', true);

            return alerts('Regras de saque editado com sucesso!', 'success');
        }

        return alerts('Erro ao editar regras de saque. Tente novamente.', 'danger');
    }

    public function EditarRendimento()
    {

        $configuracoes = [];

        $rendimento_taxa_banco = $this->input->post('rendimento_taxa_banco', true);
        $rendimento_taxa_percentual = $this->input->post('rendimento_taxa_percentual', true);

        $rendimento_minimo_banco = $this->input->post('rendimento_minimo_banco', true);
        $rendimento_minimo_valor = $this->input->post('rendimento_minimo_valor', true);

        $rendimento_dias_semana = $this->input->post('rendimento_dias_semana', true);
        $rendimento_horario_inicial = $this->input->post('rendimento_horario_inicial', true);
        $rendimento_horario_final = $this->input->post('rendimento_horario_final', true);

        foreach ($rendimento_taxa_banco as $key => $banco) {

            $percentual = $rendimento_taxa_percentual[$key];

            if (!empty($banco) && !empty($percentual)) {

                $configuracoes['taxas'][$banco] = (float)$percentual;
            }
        }

        foreach ($rendimento_minimo_banco as $key => $banco) {

            $minimo = $rendimento_minimo_valor[$key];

            if (!empty($banco) && !empty($minimo)) {

                $configuracoes['minimos'][$banco] = (float)$minimo;
            }
        }

        foreach ($rendimento_dias_semana as $key => $dia) {

            $hora_inicial = $rendimento_horario_inicial[$key];
            $hora_final = $rendimento_horario_final[$key];

            if ($dia !== '' && !empty($hora_inicial) && !empty($hora_final)) {

                $configuracoes['liberacao'][$dia] = array((int)$hora_inicial, (int)$hora_final);
            }
        }

        $update = $this->db->update('configuracoes_sistema', array(
            'configuracoes_saque_rendimento' => json_encode($configuracoes)
        ));

        if ($update) {




            CreateLog($this->userid, 'Atualizou as configurações de Saque de Rendimento.', true);

            return alerts('Configurações do Saque de Rendimento atualizados com sucesso!', 'success');
        }

        return alerts('Não foi possível atualizar as configurações de saque de rendimento. Tente novamente.', 'danger');
    }

    public function EditarRede()
    {

        $configuracoes = [];

        $rede_taxa_banco = $this->input->post('rede_taxa_banco', true);
        $rede_taxa_percentual = $this->input->post('rede_taxa_percentual', true);

        $rede_minimo_banco = $this->input->post('rede_minimo_banco', true);
        $rede_minimo_valor = $this->input->post('rede_minimo_valor', true);

        $rede_dias_semana = $this->input->post('rede_dias_semana', true);
        $rede_horario_inicial = $this->input->post('rede_horario_inicial', true);
        $rede_horario_final = $this->input->post('rede_horario_final', true);

        foreach ($rede_taxa_banco as $key => $banco) {

            $percentual = $rede_taxa_percentual[$key];

            if (!empty($banco) && !empty($percentual)) {

                $configuracoes['taxas'][$banco] = (float)$percentual;
            }
        }

        foreach ($rede_minimo_banco as $key => $banco) {

            $minimo = $rede_minimo_valor[$key];

            if (!empty($banco) && !empty($minimo)) {

                $configuracoes['minimos'][$banco] = (float)$minimo;
            }
        }

        foreach ($rede_dias_semana as $key => $dia) {

            $hora_inicial = $rede_horario_inicial[$key];
            $hora_final = $rede_horario_final[$key];

            if ($dia !== '' && !empty($hora_inicial) && !empty($hora_final)) {

                $configuracoes['liberacao'][$dia] = array((int)$hora_inicial, (int)$hora_final);
            }
        }

        $update = $this->db->update('configuracoes_sistema', array(
            'configuracoes_saque_rede' => json_encode($configuracoes)
        ));

        if ($update) {




            CreateLog($this->userid, 'Atualizou as configurações de Saque de Rede.', true);

            return alerts('Configurações do Saque de Rede atualizados com sucesso!', 'success');
        }

        return alerts('Não foi possível atualizar as configurações de saque de rede. Tente novamente.', 'danger');
    }

    public function EditarPix()
    {

        $habilitar_pix = $this->input->post('habilitar_pix', true);
        $pix = $this->input->post('pix', true);
        $tipo_pix = $this->input->post('tipo_pix', true);

        $this->db->update('configuracoes_sistema', array(
            'habilitar_pix' => $habilitar_pix,
            'chave_pix' => $pix,
            'tipo_pix' => $tipo_pix
        ));




        CreateLog($this->userid, 'Atualizou as configurações gerais do pix no sistema.', true);

        return alerts('Configurações Pix atualizadas com sucesso!', 'success');
    }

    public function EditarPixGerencianet()
    {

        $config['upload_path'] = 'application/third_party/pix';
        $config['allowed_types'] = 'pem';
        $config['file_name'] = 'gerencianet.pem';
        $config['overwrite'] = true;

        $cliente_id = $this->input->post('cliente_id', true);
        $cliente_secret = $this->input->post('cliente_secret', true);

        if (!empty($_FILES['certificado']['tmp_name'])) {

            $this->upload->initialize($config);

            if (!$this->upload->do_upload('certificado')) {

                return alerts('Ocorreu um erro ao fazer upload do seu arquivo: ' . $this->upload->display_errors(), 'danger');
            }
        }

        $this->db->update('configuracoes_sistema', array(
            'gerencianet_client_id' => $cliente_id,
            'gerencianet_client_secret' => $cliente_secret,
        ));




        CreateLog($this->userid, 'Atualizou as configurações Gerencianet (Pix).', true);

        return alerts('API Gerencianet atualizada com sucesso!', 'success');
    }

    public function EditarSimplePay()
    {

        $habilitar_simplepay = $this->input->post('habilitar_simplepay', true);
        $simplepay = $this->input->post('simplepay', true);
        $token = $this->input->post('token_simplepay', true);

        $this->db->update('configuracoes_sistema', array(
            'habilitar_simplepay' => $habilitar_simplepay,
            'conta_simplepay' => $simplepay,
            'token_simplepay' => $token
        ));




        CreateLog($this->userid, 'Atualizou os dados da SimplePay do sistema', true);

        return alerts('Dados atualizados com sucesso!', 'success');
    }

    public function EditarBankOn()
    {

        $habilitar_bankon = $this->input->post('habilitar_bankon', true);
        $bankon = $this->input->post('bankon', true);
        $token_consulta = $this->input->post('token_consulta', true);
        $token_transferencia = $this->input->post('token_transferencia', true);

        $this->db->update('configuracoes_sistema', array(
            'habilitar_bankon' => $habilitar_bankon,
            'conta_bankon' => $bankon,
            'token_bankon_consulta' => $token_consulta,
            'token_bankon_transferencia' => $token_transferencia
        ));




        CreateLog($this->userid, 'Atualizou os dados da BankOn do sistema', true);

        return alerts('Dados atualizados com sucesso!', 'success');
    }

    public function EditarCoinpayments()
    {

        $cryptosSelected = array();

        $habilitar = $this->input->post('habilitar', true);
        $public_key = $this->input->post('public_key', true);
        $private_key = $this->input->post('private_key', true);
        $merchant = $this->input->post('merchant', true);
        $cryptos = $this->input->post('cryptos', true);

        if (!empty($cryptos)) {
            foreach ($cryptos as $crypto) {

                $cryptoName = CryptoName($crypto);

                if ($cryptoName !== false) {

                    $cryptosSelected[$crypto] = $cryptoName;
                }
            }
        }

        $this->db->update('configuracoes_sistema', array(
            'coinpayments_habilitar' => $habilitar,
            'coinpayments_public_key' => $public_key,
            'coinpayments_private_key' => $private_key,
            'coinpayments_merchant' => $merchant,
            'coinpayments_cryptos' => json_encode($cryptosSelected)
        ));




        CreateLog($this->userid, 'Atualizou as configurações da CoinPayments do sistema', true);

        return alerts('Dados atualizados com sucesso!', 'success');
    }

    public function EditarRecaptcha()
    {

        $site_key = $this->input->post('site_key', true);
        $secret_key = $this->input->post('secret_key', true);
        $lang = $this->input->post('lang', true);
        $align = $this->input->post('align', true);

        $this->db->update('configuracoes_sistema', array(
            'recaptcha_site_key' => $site_key,
            'recaptcha_secret_key' => $secret_key,
            'recaptcha_lang' => $lang,
            'recaptcha_align' => $align
        ));




        CreateLog($this->userid, 'Atualizou os dados do Recaptcha do sistema.', true);

        return alerts('Dados atualizados com sucesso!', 'success');
    }

    public function EditarRaiz()
    {

        $taxa_saque_raiz = $this->input->post('taxa_saque_raiz', true);
        $pagamento_raiz = $this->input->post('pagamento_raiz', true);

        $this->db->update('configuracoes_sistema', array(
            'taxa_saque_raiz' => $taxa_saque_raiz,
            'pagamento_raiz' => $pagamento_raiz
        ));




        CreateLog($this->userid, 'Atualizou as configurações de Raiz do sistema.', true);

        return alerts('Configurações de Raiz atualizadas com sucesso!', 'success');
    }

    public function EditarAuthy()
    {

        $authy_habilitar = $this->input->post('authy_habilitar', true);
        $token = $this->input->post('token', true);

        $this->db->update('configuracoes_sistema', array(
            'authy_habilitar' => $authy_habilitar,
            'authy_token' => $token
        ));




        CreateLog($this->userid, 'Atualizou as configurações do Authy do sistema.', true);

        return alerts('Configurações Authy atualizado com sucesso!', 'success');
    }

    public function EditarTwilioSMS()
    {

        $pages = array();

        $sms_habilitar = $this->input->post('sms_habilitar', true);
        $sid = $this->input->post('sid', true);
        $token = $this->input->post('token', true);
        $service_id = $this->input->post('service_id', true);
        $twilio_sms_page = $this->input->post('twilio_sms_page', true);

        if (is_array($twilio_sms_page)) {
            foreach ($twilio_sms_page as $page) {

                $pages[] = $page;
            }
        }

        $this->db->update('configuracoes_sistema', array(
            'twilio_sms_habilitar' => $sms_habilitar,
            'twilio_sms_sid' => $sid,
            'twilio_sms_token' => $token,
            'twilio_sms_service_id' => $service_id,
            'twilio_sms_paginas' => json_encode($pages)
        ));




        CreateLog($this->userid, 'Atualizou as configurações do Twillio SMS do sistema.', true);

        return alerts('Configurações de Twillio SMS atualizadas com sucesso!', 'success');
    }

    public function EditarAsaas()
    {

        $asaas_habilitado = $this->input->post('asaas_habilitado', true);
        $asaas_vencimento = $this->input->post('asaas_vencimento', true);
        $asaas_token = $this->input->post('asaas_token', true);

        $this->db->update('configuracoes_sistema', array(
            'asaas_habilitado' => $asaas_habilitado,
            'asaas_vencimento' => $asaas_vencimento,
            'asaas_token' => $asaas_token
        ));




        CreateLog($this->userid, 'Atualizou as configurações da Asaas do sistema.', true);

        return alerts('Configurações Asaas atualizada com sucesso!', 'success');
    }

    public function SalvarGrupos()
    {

        $grupos = array();

        $grupo_name = $this->input->post('grupo_name', true);
        $grupo_link = $this->input->post('grupo_link', true);

        if (!empty($grupo_name)) {

            foreach ($grupo_name as $key => $grupoNameInput) {

                $grupoLinkInput = $grupo_link[$key];

                $grupos[trim($grupoNameInput)] = trim($grupoLinkInput);
            }
        }

        $this->db->update('configuracoes_sistema', array(
            'grupos_afiliados' => json_encode($grupos)
        ));




        CreateLog($this->userid, 'Atualizou os grupos de afiliados.', true);

        return alerts('Grupos atualizados com sucesso!', 'success');
    }

    public function EditarTelegram()
    {

        $habilitar = $this->input->post('habilitar', true);
        $chatid_telegram = $this->input->post('chatid_telegram', true);
        $token = $this->input->post('token', true);

        $this->db->update('configuracoes_sistema', array(
            'habilitar_telegram' => $habilitar,
            'chatid_telegram' => $chatid_telegram,
            'token_telegram' => $token
        ));




        CreateLog($this->userid, 'Atualizou as configurações da API do Telegram', true);

        return alerts('Configurações do Telegram atualizadas com sucesso!', 'success');
    }
}
