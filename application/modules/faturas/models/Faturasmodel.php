<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

class Faturasmodel extends CI_Model
{

    protected $rotas;

    public function __construct()
    {
        parent::__construct();

        $this->userid = $this->session->userdata('myuserid');

        $this->rotas = MinhasRotas();

        $this->load->library('upload');
        $this->load->library('bankon');
        $this->load->library('simplepay');
        $this->load->library('pix');
        $this->load->library('asaas');
    }

    public function MinhasFaturas()
    {

        $this->db->select('p.nome, f.*');
        $this->db->from('faturas AS f');
        $this->db->join('planos AS p', 'p.id = f.id_plano', 'inner');
        $this->db->where('f.status', 0);
        $this->db->where('f.id_usuario', $this->userid);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            return $query->result();
        }

        return false;
    }

    public function ExcluirFatura($id)
    {

        $this->db->where('id_usuario', $this->userid);
        $this->db->where('status', 0);
        $this->db->where('id', $id);
        $query = $this->db->get('faturas');

        if ($query->num_rows() > 0) {

            $this->db->where('id', $id);
            $this->db->delete('faturas');

            CreateLog($this->userid, 'Excluiu a fatura de ID #' . $id);

            $this->session->set_flashdata('message_faturas', alerts($this->lang->line('fat_deletada_ok'), 'success'));
        } else {

            $this->session->set_flashdata('message_faturas', alerts($this->lang->line('fat_deletada_error'), 'danger'));
        }

        redirect($this->rotas->faturas_lista);
    }

    public function MinhaFatura($id)
    {

        $this->db->where('id', $id);
        $this->db->where('id_usuario', $this->userid);
        $query = $this->db->get('faturas');

        if ($query->num_rows() > 0) {

            return $query->row();
        }

        return false;
    }

    public function paymentQRCodePix($id_fatura)
    {

        $tipoPix = SystemInfo('tipo_pix');

        if ($tipoPix == 1) {

            return $this->PixQRCodeDynamic($id_fatura);
        }

        return $this->PixQRCodeStatic($id_fatura);
    }

    public function PixQRCodeDynamic($id_fatura)
    {

        $nameUser = UserInfo('nome');
        $cpfUser = str_replace(array('.', '-', '/', ' '), array('', '', '', ''), UserInfo('documento'));

        $nameUser = UserInfo('nome');
        $splitName = explode(' ', $nameUser);
        $nameUser = sanitizeString($splitName[0]);

        $this->db->select('f.*, u.nome');
        $this->db->from('faturas AS f');
        $this->db->join('usuarios_cadastros AS u', 'u.id = f.id_usuario', 'inner');
        $this->db->where('f.id', $id_fatura);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $row = $query->row();

            $request = [
                'calendario' => [
                    'expiracao' => (60 * 60)
                ],
                'devedor' => [
                    'cpf' => $cpfUser,
                    'nome' => $nameUser
                ],
                'valor' => [
                    'original' => number_format(addCentavos($row->valor, $id_fatura), 2, '.', '')
                ],
                'chave' => SystemInfo('chave_pix'),
                'solicitacaoPagador' => 'Pagamento Fatura ' . $row->id
            ];



            $this->db->where('id_fatura', $id_fatura);
            $queryCheckInvoicePix = $this->db->get('transacoes_pix');

            if ($queryCheckInvoicePix->num_rows() > 0) {

                $rowPix = $queryCheckInvoicePix->row();

                if ($rowPix->status == 0) {

                    if (date('Y-m-d H:i:s') >= $rowPix->data_expiracao) {

                        $txID = strtoupper(GenerateCode(12)) . rand(11111111111111, 99999999999999);

                        $createCharge = $this->pix->createCharge($txID, $request);

                        if (isset($createCharge['location'])) {

                            $url = $createCharge['location'];

                            $this->db->where('id', $id_fatura);
                            $this->db->update('transacoes_pix', array(
                                'txid' => $txID,
                                'url' => $url,
                                'valor' => addCentavos($row->valor, $id_fatura),
                                'status' => 0,
                                'data_expiracao' => date('Y-m-d H:i:s', (time() + (60 * 60)))
                            ));
                        }
                    } else {

                        $url = $rowPix->url;
                        $txID = $rowPix->txid;
                    }
                } else {

                    return false;
                }
            } else {

                $txID = strtoupper(GenerateCode(12)) . rand(11111111111111, 99999999999999);

                $createCharge = $this->pix->createCharge($txID, $request);

                if (isset($createCharge['location'])) {

                    $url = $createCharge['location'];

                    $this->db->insert('transacoes_pix', array(
                        'id_usuario' => $this->userid,
                        'id_fatura' => $id_fatura,
                        'txid' => $txID,
                        'url' => $url,
                        'valor' => addCentavos($row->valor, $id_fatura),
                        'status' => 0,
                        'data_criacao' => date('Y-m-d H:i:s'),
                        'data_expiracao' => date('Y-m-d H:i:s', (time() + (60 * 60)))
                    ));
                }
            }

            if (isset($url)) {

                $pixMount = $this->pix->setMerchantName($nameUser)
                    ->setMerchantCity('BRASIL')
                    ->setTxid($txID)
                    ->setAmount(addCentavos($row->valor, $id_fatura))
                    ->setUrlDynamicPayload($url)
                    ->setUniquePayment(true);

                $infoCode = $pixMount->getCode();

                $newQRCode = new QrCode($infoCode);
                $imageQRCode = (new Output\Png)->output($newQRCode, 300);

                return base64_encode($imageQRCode);
            }
        }

        return $this->PixQRCodeStatic($id_fatura);
    }

    public function PixQRCodeStatic($id_fatura)
    {

        $nameUser = UserInfo('nome');
        $splitName = explode(' ', $nameUser);
        $nameUser = sanitizeString($splitName[0]);

        $this->db->select('f.*, u.nome');
        $this->db->from('faturas AS f');
        $this->db->join('usuarios_cadastros AS u', 'u.id = f.id_usuario', 'inner');
        $this->db->where('f.id', $id_fatura);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $row = $query->row();

            $pixMount = $this->pix->setPixKey(SystemInfo('chave_pix'))
                ->setMerchantName($nameUser)
                ->setMerchantCity('BRASIL')
                ->setDescription('PAG. DA FATURA ' . $id_fatura)
                ->setAmount(addCentavos($row->valor, $id_fatura));

            $infoCode = $pixMount->getCode();

            $newQRCode = new QrCode($infoCode);
            $imageQRCode = (new Output\Png)->output($newQRCode, 300);

            return base64_encode($imageQRCode);
        }

        return false;
    }

    public function EnviarComprovante($id_fatura)
    {

        $config['upload_path'] = 'uploads/comprovantes';
        $config['allowed_types'] = 'jpeg|jpg|gif|png|pdf';
        $config['encrypt_name'] = true;

        $banco = $this->input->post('banco', true);
        $token = $this->input->post('token', true);
        $action = $this->input->post('action', true);

        // $responseRecaptcha = $this->recaptcha->verifyResponse($token, $action);

        // if (isset($responseRecaptcha['success']) && $responseRecaptcha['success'] === true) {

        $this->upload->initialize($config);

        if ($this->upload->do_upload('comprovante')) {

            $data = $this->upload->data();

            $this->db->where('id_fatura', $id_fatura);
            $this->db->where('status != ', 2);
            $query = $this->db->get('faturas_comprovantes');

            if ($query->num_rows() > 0) {

                $row = $query->row();

                if ($row->status == 1) {

                    return alerts($this->lang->line('fat_envio_comprovante_nao_permitido'), 'danger');
                }

                $this->db->where('id_fatura', $id_fatura);
                $this->db->update('faturas_comprovantes', array(
                    'comprovante' => base_url('uploads/comprovantes/' . $data['file_name']),
                    'data_atualizacao' => date('Y-m-d H:i:s')
                ));
            } else {

                $this->db->insert('faturas_comprovantes', array(
                    'id_usuario' => $this->userid,
                    'id_fatura' => $id_fatura,
                    'banco' => $banco,
                    'comprovante' => base_url('uploads/comprovantes/' . $data['file_name']),
                    'status' => 0,
                    'data_criacao' => date('Y-m-d H:i:s'),
                    'data_atualizacao' => date('Y-m-d H:i:s')
                ));
            }

            CreateLog($this->userid, 'Enviou um comprovante de depósito referente a fatura ID #' . $id_fatura);

            return alerts($this->lang->line('fat_envio_comprovante_ok'), 'success');
        }

        return alerts(sprintf($this->lang->line('fat_envio_comprovante_error'), $this->upload->display_errors()), 'danger');
        // }

        // return alerts($this->lang->line('eu_nao_sou_robo'), 'danger');
    }

    public function AtivarBankOn($id_fatura)
    {

        $codigo_bankon = $this->input->post('codigo_bankon', true);
        $token = $this->input->post('token', true);
        $action = $this->input->post('action', true);

        $responseRecaptcha = $this->recaptcha->verifyResponse($token, $action);

        if (isset($responseRecaptcha['success']) && $responseRecaptcha['success'] === true) {

            $codigo_bankon = trim($codigo_bankon);
            $codigo_bankon = preg_replace('/[^a-zA-Z0-9]/', '', $codigo_bankon);

            $this->db->where('codigo', $codigo_bankon);
            $queryCodigo = $this->db->get('transacoes_bankon');

            if ($queryCodigo->num_rows() > 0) {

                return alerts($this->lang->line('fat_pagamento_via_bankon_codigo_ja_utilizado'), 'danger');
            }

            $validacao = $this->bankon->ConsultarTransacao($codigo_bankon);

            if ($validacao === false) {

                return alerts($this->lang->line('fat_pagamento_via_bankon_validacao_off'), 'danger');
            }

            $this->db->where('id', $id_fatura);
            $this->db->where('id_usuario', $this->userid);
            $queryFatura = $this->db->get('faturas');

            if ($queryFatura->num_rows() > 0) {

                $row = $queryFatura->row();

                if ($row->status == 0) {

                    if (isset($validacao->sucesso) && $validacao->sucesso == 'true') {

                        $bankOnOficial = str_replace('@', '', SystemInfo('conta_bankon'));

                        if ($bankOnOficial == $validacao->Dados->destino->usuario) {

                            $valorFatura = number_format($row->valor, 2, '.', '');

                            if ($validacao->Dados->valor == $valorFatura) {

                                $active = $this->SystemModel->AtivarFatura($id_fatura, 'BankOn', 'Ativado com código BankOn: ' . $codigo_bankon, false, 1);


                                if ($active) {

                                    $this->db->insert('transacoes_bankon', array(
                                        'id_usuario' => $this->userid,
                                        'id_fatura' => $id_fatura,
                                        'bankon' => $validacao->Dados->origem->usuario,
                                        'codigo' => $codigo_bankon,
                                        'valor' => $row->valor,
                                        'data_transacao' => date('Y-m-d H:i:s', strtotime($validacao->Dados->data)),
                                        'data_utilizacao' => date('Y-m-d H:i:s')
                                    ));

                                    CreateLog($this->userid, 'O usuário acabou de ativar a fatura ID #' . $id_fatura . ' com bankOn');

                                    return alerts($this->lang->line('fat_pagamento_via_bankon_ativacao_ok'), 'success');
                                }

                                return alerts($this->lang->line('fat_pagamento_via_bankon_ativacao_error'), 'danger');
                            }

                            return alerts($this->lang->line('fat_pagamento_via_bankon_ativacao_error_divergencia'), 'danger');
                        }

                        return alerts($this->lang->line('fat_pagamento_via_bankon_ativacao_error_conta_nao_oficial'), 'danger');
                    }

                    return alerts($this->lang->line('fat_pagamento_via_bankon_ativacao_error_codigo_invalido'), 'danger');
                }

                return alerts($this->lang->line('fat_pagamento_via_bankon_ativacao_error_fatura_ja_ativa'), 'danger');
            }

            return alerts($this->lang->line('fat_pagamento_via_bankon_ativacao_error_fatura_invalida'), 'danger');
        }

        return alerts($this->lang->line('eu_nao_sou_robo'), 'danger');
    }

    public function AtivarSimplePay($id_fatura)
    {

        $codigo_simplepay = $this->input->post('codigo_simplepay', true);
        $token = $this->input->post('token', true);
        $action = $this->input->post('action', true);

        $responseRecaptcha = $this->recaptcha->verifyResponse($token, $action);

        if (isset($responseRecaptcha['success']) && $responseRecaptcha['success'] === true) {

            $codigo_simplepay = trim($codigo_simplepay);
            $codigo_simplepay = preg_replace('/[^a-zA-Z0-9]/', '', $codigo_simplepay);

            $this->db->where('codigo', $codigo_simplepay);
            $queryCodigo = $this->db->get('transacoes_simplepay');

            if ($queryCodigo->num_rows() > 0) {

                return alerts($this->lang->line('fat_pagamento_via_simplepay_codigo_ja_utilizado'), 'danger');
            }

            $validacao = $this->simplepay->ConsultarTransacao($codigo_simplepay);

            if ($validacao === false) {

                return alerts($this->lang->line('fat_pagamento_via_simplepay_validacao_off'), 'danger');
            }

            $this->db->where('id', $id_fatura);
            $this->db->where('id_usuario', $this->userid);
            $queryFatura = $this->db->get('faturas');

            if ($queryFatura->num_rows() > 0) {

                $row = $queryFatura->row();

                if ($row->status == 0) {

                    if (isset($validacao->success) && $validacao->success == 'true') {

                        $simplePayOficial = str_replace('@', '', SystemInfo('conta_simplepay'));

                        if ($simplePayOficial == $validacao->destino) {

                            $valorFatura = number_format($row->valor, 2, '.', '');

                            if ($validacao->valor == $valorFatura) {

                                $active = $this->SystemModel->AtivarFatura($id_fatura, 'SimplePay', 'Ativado com código SimplePay: ' . $codigo_simplepay);

                                if ($active) {

                                    $this->db->insert('transacoes_simplepay', array(
                                        'id_usuario' => $this->userid,
                                        'id_fatura' => $id_fatura,
                                        'simplepay' => $validacao->origem,
                                        'codigo' => $codigo_simplepay,
                                        'valor' => $row->valor,
                                        'data_transacao' => date('Y-m-d H:i:s', $validacao->data_unix),
                                        'data_utilizacao' => date('Y-m-d H:i:s')
                                    ));

                                    CreateLog($this->userid, 'O usuário acabou de ativar a fatura ID #' . $id_fatura . ' com simplepay');

                                    return alerts($this->lang->line('fat_pagamento_via_simplepay_ativacao_ok'), 'success');
                                }

                                return alerts($this->lang->line('fat_pagamento_via_simplepay_ativacao_error'), 'danger');
                            }

                            return alerts($this->lang->line('fat_pagamento_via_simplepay_ativacao_error_divergencia'), 'danger');
                        }

                        return alerts($this->lang->line('fat_pagamento_via_simplepay_ativacao_error_conta_nao_oficial'), 'danger');
                    }

                    return alerts($this->lang->line('fat_pagamento_via_simplepay_ativacao_error_codigo_invalido'), 'danger');
                }

                return alerts($this->lang->line('fat_pagamento_via_simplepay_ativacao_error_fatura_ja_ativa'), 'danger');
            }

            return alerts($this->lang->line('fat_pagamento_via_simplepay_ativacao_error_fatura_invalida'), 'danger');
        }

        return alerts($this->lang->line('eu_nao_sou_robo'), 'danger');
    }

    public function GerarBoletoAsaas($id_fatura)
    {

        $this->db->where('id', $id_fatura);
        $this->db->where('id_usuario', $this->userid);
        $query = $this->db->get('faturas');

        if ($query->num_rows() > 0) {

            $row = $query->row();

            $this->db->where('id_fatura', $id_fatura);
            $queryBoleto = $this->db->get('transacoes_asaas');

            if ($queryBoleto->num_rows() <= 0) {

                $dataClient = array(
                    'name' => UserInfo('nome'),
                    'cpfCnpj' => str_replace(array('.', '-', ' '), array('', '', ''), (string)UserInfo('documento'))
                );

                $clientID = $this->asaas->createClient($dataClient);

                if (!is_array($clientID)) {

                    $dueDate = date('Y-m-d', (time() + (60 * 60 * 24 * SystemInfo('asaas_vencimento'))));

                    $dataBilling = array(
                        'customer' => $clientID,
                        'billingType' => 'BOLETO',
                        'value' => ($row->valor + 2.99),
                        'dueDate' => $dueDate,
                        'description' => 'Fatura #' . $id_fatura,
                        'externalReference' => $id_fatura,
                        'postalService' => false
                    );

                    $createBilling = $this->asaas->createBilling($dataBilling);

                    if (isset($createBilling->id)) {

                        $idBoleto = $createBilling->id;
                        $invoiceNumber = $createBilling->invoiceNumber;
                        $boleto = $createBilling->bankSlipUrl;

                        $this->db->insert('transacoes_asaas', array(
                            'id_usuario' => $this->userid,
                            'id_fatura' => $id_fatura,
                            'id_boleto' => $idBoleto,
                            'invoice_number' => $invoiceNumber,
                            'link_boleto' => $boleto,
                            'status' => 0,
                            'data_vencimento' => $dueDate,
                            'data_criacao' => date('Y-m-d H:i:s')
                        ));


                        CreateLog($this->userid, 'Gerou um boleto bancário ' . $boleto . ' para pagamento da fatura ID #' . $id_fatura . ' de ' . MOEDA . ' ' . number_format($row->valor, 2, ',', '.'));

                        redirect($boleto);
                        exit;
                    }

                    echo $this->lang->line('fat_pagamento_via_boleto_nao_foi_possivel_gb');

                    if (isset($createBilling->description)) {
                        echo $createBilling->description;
                    } else {

                        echo $this->lang->line('fat_pagamento_via_boleto_nao_foi_possivel_tente_novamente');
                    }
                } else {

                    echo $this->lang->line('fat_pagamento_via_boleto_nao_foi_possivel_cc');
                    echo '<br />';

                    if (isset($clientID[0]->description)) {
                        echo $clientID[0]->description;
                    } else {
                        echo $this->lang->line('fat_pagamento_via_boleto_nao_foi_possivel_tente_novamente');
                    }
                }
            } else {

                $rowBoleto = $queryBoleto->row();

                redirect($rowBoleto->link_boleto);
                exit;
            }
        } else {

            echo alerts($this->lang->line('fat_pagamento_via_boleto_fatura_invalida_dono'), 'error');
        }
    }

    public function GerarPix($id_fatura)
    {

        $this->db->where('id', $id_fatura);
        $this->db->where('id_usuario', $this->userid);
        $query = $this->db->get('faturas');

        if ($query->num_rows() > 0) {

            $row = $query->row();

            $this->db->where('id_fatura', $id_fatura);
            $queryBoleto = $this->db->get('transacoes_pix');

            if ($queryBoleto->num_rows() <= 0) {

                $dataClient = array(
                    'name' => UserInfo('nome'),
                    'cpfCnpj' => str_replace(array('.', '-', ' '), array('', '', ''), (string)UserInfo('documento'))
                );

                $clientID = $this->asaas->createClient($dataClient);

                if (!is_array($clientID)) {

                    $dueDate = date('Y-m-d', (time() + (60 * 60 * 24 * SystemInfo('asaas_vencimento'))));

                    $dataBilling = array(
                        'customer' => $clientID,
                        'billingType' => 'PIX',
                        'value' => $row->valor,
                        'dueDate' => $dueDate,
                        'description' => 'Fatura #' . $id_fatura,
                        'externalReference' => $id_fatura,
                        'postalService' => false
                    );

                    $createBilling = $this->asaas->createBilling($dataBilling);

                    if (isset($createBilling->id)) {

                        $idPix = $createBilling->id;
                        $invoiceNumber = $createBilling->invoiceNumber;
                        $qrcode = $this->asaas->createQRCodePix($idPix);

                        if (!$qrcode) {
                            return false;
                        }

                        $this->db->insert('transacoes_pix', array(
                            'id_usuario' => $this->userid,
                            'id_fatura' => $id_fatura,
                            'loc_id' => 0,
                            'txid' => $idPix,
                            'url' => $invoiceNumber,
                            'base64' => $qrcode['base64'],
                            'cc' => $qrcode['cc'],
                            'valor' => $row->valor,
                            'status' => 0,
                            'data_criacao' => date('Y-m-d H:i:s'),
                        ));

                        return [
                            'base64' => $qrcode['base64'],
                            'cc' => $qrcode['cc']
                        ];
                    }

                    return false;
                } else {
                    return false;
                }
            } else {

                $rowBoleto = $queryBoleto->row();

                return [
                    'base64' => $rowBoleto->base64,
                    'cc' => $rowBoleto->cc
                ];
            }
        } else {
            return false;
        }
    }

    public function BancosCadastrados()
    {

        $this->db->order_by('banco', 'ASC');
        $query = $this->db->get('configuracoes_contas_bancarias');

        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return false;
    }
}
