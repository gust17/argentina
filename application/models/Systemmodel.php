<?php
class Systemmodel extends CI_Model
{

    public $sponsers = [];

    public function __construct()
    {
        parent::__construct();

        $this->userid = $this->session->userdata('myuserid');
    }

    public function SearchSponsers($id, $count, $limit)
    {

        if ($count <= $limit) {

            $this->db->where('id_usuario', $id);
            $queryNetwork = $this->db->get('rede');

            if ($queryNetwork->num_rows() > 0) {

                foreach ($queryNetwork->result() as $resultNetwork) {

                    $idSponsers = $resultNetwork->id_patrocinador_direto;

                    $this->sponsers[$count] = $idSponsers;

                    $this->SearchSponsers($idSponsers, $count + 1, $limit);
                }
            }
        }
    }

    public function InitializeSponsers($id_user)
    {

        $limit = SystemInfo('niveis_unilevel');

        $this->SearchSponsers($id_user, 1, $limit);

        return $this->sponsers;
    }

    public function BalancoSaldo($tipo, $saldo)
    {

        $this->db->select_sum('valor');
        $this->db->from('extrato');
        $this->db->where('id_usuario', $this->userid);
        $this->db->where('tipo_saldo', $tipo);
        $this->db->where('categoria', $saldo);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            return $query->row()->valor;
        }

        return 0;
    }

    public function RendimentoTotal()
    {

        $entrada = $this->BalancoSaldo(1, 1);
        $saida = $this->BalancoSaldo(2, 1);

        return ($entrada - $saida);
    }

    public function RedeTotal()
    {

        $entrada = $this->BalancoSaldo(1, 2);
        $saida = $this->BalancoSaldo(2, 2);

        return ($entrada - $saida);
    }

    public function RendimentoDisponivel()
    {

        $apos_vencido = SystemInfo('sacar_rendimento_apos_vencido');

        $this->db->select_sum('valor_liberado');
        $this->db->from('faturas');
        $this->db->where('id_usuario', $this->userid);

        if ($apos_vencido == 1) {
            $this->db->where('status', 2);
        } else {
            $this->db->group_start();
            $this->db->where('status', 1);
            $this->db->or_where('status', 2);
            $this->db->group_end();
        }

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            return $query->row()->valor_liberado;
        }

        return 0;
    }

    public function FaturasRendimentoDisponivel()
    {

        $array = [];

        $apos_vencido = SystemInfo('sacar_rendimento_apos_vencido');

        $this->db->select('*');
        $this->db->from('faturas');
        $this->db->where('id_usuario', $this->userid);
        $this->db->order_by('valor_liberado', 'ASC');

        if ($apos_vencido == 1) {
            $this->db->where('status', 2);
        } else {
            $this->db->group_start();
            $this->db->where('status', 1);
            $this->db->or_where('status', 2);
            $this->db->group_end();
        }

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $result) {

                $array[] = array(
                    'id_fatura' => $result->id,
                    'valor_liberado' => $result->valor_liberado
                );
            }
        }

        return $array;
    }

    public function SaldoUltimosDias($dias = 7, $tipo = 1, $saldo = 1)
    {

        $query = $this->db->query("SELECT COALESCE(SUM(valor),0) AS valor FROM extrato WHERE id_usuario = '" . $this->userid . "' AND tipo_saldo = '" . $tipo . "' AND categoria = '" . $saldo . "' AND data_criacao >= DATE(NOW()) - INTERVAL " . $dias . " DAY");

        if ($query->num_rows() > 0) {

            return $query->row()->valor;
        }

        return 0;
    }

    public function AtivarFatura($idInvoice, $via = '', $interno = '', $cortesia = false, $bonusScore = 0)
    {

        $this->db->select('f.*, p.pontos, p.nome, p.posicao, p.score_ganho');
        $this->db->from('faturas AS f');
        $this->db->join('planos AS p', 'f.id_plano = p.id', 'inner');
        $this->db->where('f.id', $idInvoice);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $rowInvoice = $query->row();

            if ($rowInvoice->status == 0) {

                $firstPayment = DiasUteis(date('Y-m-d'), 1);

                $cortesia_status = ($cortesia) ? 1 : 0;

                $this->db->where('id', $idInvoice);
                $updateStatusInvoice = $this->db->update('faturas', array(
                    'status' => 1,
                    'cortesia' => $cortesia_status,
                    'data_pagamento' => date('Y-m-d H:i:s'),
                    'data_primeiro_recebimento' => $firstPayment,
                    'meio_pagamento' => $via,
                    'meio_pagamento_detalhes' => $interno
                ));

                if ($updateStatusInvoice) {

                    $this->db->where('id_fatura', $idInvoice);
                    $this->db->update('faturas_comprovantes', array('status' => 1, 'data_atualizacao' => date('Y-m-d H:i:s')));

                    $this->db->where('id', $rowInvoice->id_usuario);
                    $this->db->update('usuarios_cadastros', array(
                        'plano_ativo' => 1,
                    ));

                    /* Initilize Payment of Indications */

                    if (!$cortesia) {

                        $MySponsers = $this->InitializeSponsers($rowInvoice->id_usuario);

                        if (!empty($MySponsers)) {

                            $loginComprador = UserInfo('login', $rowInvoice->id_usuario);

                            foreach ($MySponsers as $nivel => $idSponser) {

                                $sponserActived = UserInfo('plano_ativo', $idSponser);

                                /* Send Points of the first level */

                                if ($nivel == 1) {

                                    $pontosAtuais = UserInfo('pontos_carreira', $idSponser);

                                    $novosPontos = $pontosAtuais + $rowInvoice->pontos;

                                    $this->db->where('id', $idSponser);
                                    $this->db->update('usuarios_cadastros', array(
                                        'pontos_carreira' => $novosPontos
                                    ));
                                }

                                $this->db->select('f.*, u.celular');
                                $this->db->from('faturas AS f');
                                $this->db->join('usuarios_cadastros AS u', 'u.id = f.id_usuario', 'inner');
                                $this->db->where('f.status', 1);
                                $this->db->where('f.id_usuario', $idSponser);
                                $this->db->order_by('f.valor', 'DESC');
                                $this->db->limit(1);
                                $queryInvoicesSponser = $this->db->get();

                                if ($queryInvoicesSponser->num_rows() > 0) {

                                    $rowInvoiceSponser = $queryInvoicesSponser->row();

                                    $niveis = json_decode($rowInvoiceSponser->niveis_indicacao, true);

                                    if (isset($niveis[$nivel])) {

                                        $porcents = $niveis[$nivel];

                                        if ($nivel == 1 && $sponserActived == 0) {
                                            $porcents = 10;
                                        }

                                        if ($via == 'Renovação' && $nivel == 1) {
                                            $porcents = $porcents / 2;
                                        } elseif ($via == 'Renovação' && $nivel != 1) {
                                            break;
                                        }

                                        $totalIndication = $rowInvoice->valor * ($porcents / 100);

                                        $message = 'Bonificação de ' . $porcents . '% de indicação sobre a ativação de uma fatura no valor de ' . MOEDA . ' ' . number_format($rowInvoice->valor, 2, ',', '.') . ' do login ' . $loginComprador . ' do seu ' . $nivel . 'º nível';

                                        RegisterExtractItem($idSponser, $message, $totalIndication, 1, 2, $idInvoice);
                                    }
                                }
                            }
                        }
                    }

                    /* End Payment of Indications */

                    $messageActivePlan = 'Plano de ' . MOEDA . ' ' . number_format($rowInvoice->valor, 2, ',', '.') . ' ativado com sucesso!';
                    CreateNotification($rowInvoice->id_usuario, $messageActivePlan);

                    CreateRegisterBox(null, 'Ativação da Fatura #' . $idInvoice . ' do usuário <b>' . UserInfo('login', $rowInvoice->id_usuario) . '</b>', 1, $rowInvoice->valor);

                    return true;
                }

                return false;
            }

            return true;
        }

        return false;
    }

    public function LeveisDisponiveis()
    {

        $this->db->order_by('level', 'ASC');
        $query = $this->db->get('levels');

        return $query->result();
    }

    public function TotalDiasRendidos($id)
    {

        $this->db->select('quantidade_pagamentos_realizados');
        $this->db->from('faturas');
        $this->db->where('id_usuario', $this->userid);
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $row = $query->row();

            return $row->quantidade_pagamentos_realizados;
        }

        return 0;
    }

    public function VerificaRecebimentoTotal($id)
    {

        $this->db->select('quantidade_pagamentos_fazer, quantidade_pagamentos_realizados');
        $this->db->from('faturas');
        $this->db->where('id_usuario', $this->userid);
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $row = $query->row();

            if ($row->quantidade_pagamentos_realizados >= $row->quantidade_pagamentos_fazer) {

                return true;
            }
        }

        return false;
    }

    public function RendimentoDisponivelFatura($id)
    {

        $this->db->select_sum('valor_liberado');
        $this->db->from('faturas');
        $this->db->where('id_usuario', $this->userid);
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            return $query->row()->valor_liberado;
        }

        return 0;
    }
}
