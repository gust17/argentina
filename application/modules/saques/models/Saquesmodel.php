<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Saquesmodel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

        $this->userid = $this->session->userdata('myuserid');
    }

    public function VoltaPrimeiroRendimento($id)
    {
        $this->db->select('ciclo, quantidade_pagamentos_realizados, quantidade_pagamentos_fazer');
        $this->db->from('faturas');
        $this->db->where('id', $id);
        $this->db->where('id_usuario', $this->userid);
        $queryFaturas = $this->db->get();

        $rowFaturas = $queryFaturas->row();

        if ($rowFaturas->quantidade_pagamentos_realizados == $rowFaturas->quantidade_pagamentos_fazer) {

            $this->db->where('id', $id);
            $this->db->where('id_usuario', $this->userid);
            $this->db->update('faturas', array(
                'quantidade_pagamentos_realizados' => 0,
                'valor_liberado' => 0,
            ));

            return false;
        }

        $this->db->where('id', $id);
        $this->db->where('id_usuario', $this->userid);
        $this->db->update('faturas', array(
            'ciclo' => ($rowFaturas->ciclo + 1),
            'quantidade_pagamentos_realizados' => 0,
            'valor_liberado' => 0,
            'status' => 1
        ));
    }

    public function VerificaDisponibilidadeCancelamento($id)
    {

        $this->db->where('id', $id);
        $this->db->where('id_usuario', $this->userid);
        $query = $this->db->get('faturas');

        if ($query->num_rows() > 0) {

            return true;
        }

        return false;
    }
    public function quantidadeSaquesEfetuados()
    {

        $this->db->where('id_usuario', $this->userid);
        $query = $this->db->get('saques');

        return $query->num_rows();
    }

    public function ValorSaquesSolicitados($status = null)
    {

        $this->db->select_sum('valor_receber');
        $this->db->from('saques');
        $this->db->where('id_usuario', $this->userid);

        if (!is_null($status)) {
            $this->db->where('status', $status);
        }
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            return $query->row()->valor_receber;
        }

        return 0;
    }

    public function MeusSaques()
    {

        $this->db->order_by('id', 'DESC');
        $this->db->where('id_usuario', $this->userid);
        $query = $this->db->get('saques');

        if ($query->num_rows() > 0) {

            return $query->result();
        }

        return false;
    }

    public function RealizarSaqueRendimento($id)
    {

        if (UserInfo('saque_liberado') == 0) {
            return alerts($this->lang->line('saq_conta_nao_habilitada'), 'danger');
        }

        $categoria_saque = 1;
        $dia_semana = date('w');
        $hora_atual = date('H');
        $faturas_usadas = [];
        $conta = (int)$this->input->post('conta', true);
        $valor = $this->SystemModel->RendimentoDisponivelFatura($id);
        $token = $this->input->post('token', true);
        $action = $this->input->post('action', true);

        $configuracoes_rendimento = SystemInfo('configuracoes_saque_rendimento');
        $configuracoes_rendimento = json_decode($configuracoes_rendimento, true);

        $colunaConta = ColunaContaRecebimento($conta);
        $conta_recebimento = UserInfo($colunaConta);

        $taxa = $configuracoes_rendimento['taxas'][$conta] ?? 0;
        $minimo_saque = $configuracoes_rendimento['minimos'][$conta] ?? 0;
        $horarios_saque = $configuracoes_rendimento['liberacao'][$dia_semana] ?? null;

        $valor_descontado_taxa = $valor - ($valor * ($taxa / 100));

        $responseRecaptcha = $this->recaptcha->verifyResponse($token, $action);

        if (isset($responseRecaptcha['success']) && $responseRecaptcha['success'] === true) {

            if (empty($configuracoes_rendimento)) {

                return alerts($this->lang->line('saq_indice_saques_erro'), 'danger');
            }

            if ($valor < $minimo_saque) {

                return alerts(sprintf($this->lang->line('saq_valor_menor_minimo'), MOEDA . ' ' . number_format($minimo_saque, 2, ',', '.')), 'danger');
            }

            if (is_null($horarios_saque)) {

                return alerts($this->lang->line('saq_valor_fora_horario'), 'danger');
            }

            if ($hora_atual < $horarios_saque[0] || $hora_atual >= $horarios_saque[1]) {

                return alerts(sprintf($this->lang->line('saq_valor_fora_horario_2'), $horarios_saque[0], $horarios_saque[1]), 'danger');
            }

            if (empty($conta_recebimento) || $conta_recebimento == '{}') {

                return alerts($this->lang->line('saq_valor_conta_nao_selecionada'), 'danger');
            }

            $this->db->insert('saques', array(
                'id_usuario' => $this->userid,
                'valor_solicitado' => $valor,
                'valor_receber' => $valor_descontado_taxa,
                'meio_recebimento' => $conta,
                'conta_recebimento' => $conta_recebimento,
                'tipo_saque' => $categoria_saque,
                'referencia_faturas' => json_encode($faturas_usadas),
                'status' => 0,
                'data_solicitacao' => date('Y-m-d H:i:s')
            ));

            $id_saque = $this->db->insert_id();

            CreateLog($this->userid, 'O usuário efetuou um saque de rendimento no valor de ' . MOEDA . ' ' . number_format($valor, 2, ',', '.'));

            if ($id_saque > 0) {

                $this->VoltaPrimeiroRendimento($id);

                CreateNotification($this->userid, 'Pronto, seu saque foi solicitado, agora é só esperar o prazo de nossa empresa e em breve você receberá em sua conta o seu dinheiro :).');

                RegisterExtractItem($this->userid, 'Solicitação de saque de rendimento', $valor, 2, 1, 'ID SAQUE: ' . $id_saque);

                return alerts($this->lang->line('saq_valor_saque_efetuado_ok'), 'success');
            }

            return alerts($this->lang->line('saq_valor_saque_efetuado_error'), 'danger');
        }

        return alerts($this->lang->line('eu_nao_sou_robo'), 'danger');
    }

    public function RealizarSaqueRede()
    {

        if (UserInfo('saque_liberado') == 0) {
            return alerts($this->lang->line('saq_conta_nao_habilitada'), 'danger');
        }


        $categoria_saque = 2;
        $dia_semana = date('w');
        $hora_atual = date('H');
        $faturas_usadas = [];
        $conta = (int)$this->input->post('conta', true);
        $valor = (float)$this->input->post('valor_' . $conta, true);
        $token = $this->input->post('token', true);
        $action = $this->input->post('action', true);
        $valor_disponivel = $this->SystemModel->RedeTotal();
        $valor_descontar = $valor;

        $configuracoes_rede = SystemInfo('configuracoes_saque_rede');
        $configuracoes_rede = json_decode($configuracoes_rede, true);

        $colunaConta = ColunaContaRecebimento($conta);
        $conta_recebimento = UserInfo($colunaConta);

        $taxa = $configuracoes_rede['taxas'][$conta] ?? 0;
        $minimo_saque = $configuracoes_rede['minimos'][$conta] ?? 0;
        $horarios_saque = $configuracoes_rede['liberacao'][$dia_semana] ?? null;

        $valor_descontado_taxa = $valor - ($valor * ($taxa / 100));

        $responseRecaptcha = $this->recaptcha->verifyResponse($token, $action);

        if (isset($responseRecaptcha['success']) && $responseRecaptcha['success'] === true) {

            // if(UserInfo('cadastro_validado') == 0){

            //     return alerts('Seu cadastro não foi validado. Por favor, envie seus documentos para validar e continuar seu saque.', 'danger');
            // }

            if (empty($configuracoes_rede)) {

                return alerts($this->lang->line('saq_indice_saques_erro'), 'danger');
            }

            if ($valor > $valor_disponivel) {

                return alerts(sprintf($this->lang->line('saq_valor_saque_insuficiente'), MOEDA . ' ' . number_format($valor_disponivel, 2, ',', '.')), 'danger');
            }

            if ($valor < $minimo_saque) {

                return alerts(sprintf($this->lang->line('saq_valor_menor_minimo'), MOEDA . ' ' . number_format($minimo_saque, 2, ',', '.')), 'danger');
            }

            if (is_null($horarios_saque)) {

                return alerts($this->lang->line('saq_valor_fora_horario'), 'danger');
            }

            if ($hora_atual < $horarios_saque[0] || $hora_atual >= $horarios_saque[1]) {

                return alerts(sprintf($this->lang->line('saq_valor_fora_horario_2'), $horarios_saque[0], $horarios_saque[1]), 'danger');
            }

            if (empty($conta_recebimento) || $conta_recebimento == '{}') {

                return alerts($this->lang->line('saq_valor_conta_nao_selecionada'), 'danger');
            }

            $this->db->insert('saques', array(
                'id_usuario' => $this->userid,
                'valor_solicitado' => $valor,
                'valor_receber' => $valor_descontado_taxa,
                'meio_recebimento' => $conta,
                'conta_recebimento' => $conta_recebimento,
                'tipo_saque' => $categoria_saque,
                'referencia_faturas' => null,
                'status' => 0,
                'data_solicitacao' => date('Y-m-d H:i:s')
            ));

            $id_saque = $this->db->insert_id();

            CreateLog($this->userid, 'O usuário efetuou um saque de rede no valor de ' . MOEDA . ' ' . number_format($valor, 2, ',', '.'));

            if ($id_saque > 0) {

                CreateNotification($this->userid, 'Pronto, seu saque foi solicitado, agora é só esperar o prazo de nossa empresa e em breve você receberá em sua conta o seu dinheiro :).');

                RegisterExtractItem($this->userid, 'Solicitação de saque de Rede', $valor, 2, 2, 'ID SAQUE: ' . $id_saque);

                return alerts($this->lang->line('saq_valor_saque_efetuado_ok'), 'success');
            }

            return alerts($this->lang->line('saq_valor_saque_efetuado_error'), 'danger');
        }

        return alerts($this->lang->line('eu_nao_sou_robo'), 'danger');
    }

    public function CancelarContrato($id)
    {

        if (UserInfo('saque_liberado') == 0) {
            return alerts($this->lang->line('saq_conta_nao_habilitada'), 'danger');
        }

        $cancelamento_contrato = SystemInfo('cancelamento_contrato');
        $cancelamento_taxa = SystemInfo('taxa_cancelamento');
        $token = $this->input->post('token', true);
        $action = $this->input->post('action', true);
        $conta = (int)$this->input->post('conta', true);

        $colunaConta = ColunaContaRecebimento($conta);
        $conta_recebimento = UserInfo($colunaConta);

        $responseRecaptcha = $this->recaptcha->verifyResponse($token, $action);

        if (isset($responseRecaptcha['success']) && $responseRecaptcha['success'] === true) {

            // if(UserInfo('cadastro_validado') == 0){

            //     return alerts('Seu cadastro não foi validado. Por favor, envie seus documentos para validar e continuar seu saque.', 'danger');
            // }

            if ($cancelamento_contrato == 1) {

                if (empty($conta_recebimento) || $conta_recebimento == '{}') {

                    return alerts($this->lang->line('saq_valor_conta_nao_selecionada'), 'danger');
                }

                $this->db->where('id', $id);
                $this->db->where('id_usuario', $this->userid);
                $this->db->where('status', 1);
                $query = $this->db->get('faturas');

                if ($query->num_rows() > 0) {

                    $row = $query->row();

                    $raiz_sacar = $row->valor - ($row->valor * ($cancelamento_taxa / 100));

                    $valorDisponivelFatura = $this->SystemModel->RendimentoDisponivelFatura($id);
                    $valorDisponivelFaturaComTaxa = $valorDisponivelFatura - ($valorDisponivelFatura * ($cancelamento_taxa / 100));

                    if ($valorDisponivelFatura > 0) {

                        $this->db->insert('saques', array(
                            'id_usuario' => $this->userid,
                            'valor_solicitado' => $valorDisponivelFatura,
                            'valor_receber' => $valorDisponivelFaturaComTaxa,
                            'meio_recebimento' => $conta,
                            'conta_recebimento' => $conta_recebimento,
                            'tipo_saque' => 1,
                            'referencia_faturas' => json_encode(array($id => $row->valor)),
                            'detalhes' => 'Saque do rendimento do plano #' . $id . ' após cancelamento',
                            'status' => 0,
                            'data_solicitacao' => date('Y-m-d H:i:s')
                        ));
                    }

                    $this->db->insert('saques', array(
                        'id_usuario' => $this->userid,
                        'valor_solicitado' => $row->valor,
                        'valor_receber' => $raiz_sacar,
                        'meio_recebimento' => $conta,
                        'conta_recebimento' => $conta_recebimento,
                        'tipo_saque' => 3,
                        'referencia_faturas' => json_encode(array($id => $row->valor)),
                        'detalhes' => 'Saque de Raiz do plano #' . $id,
                        'status' => 0,
                        'data_solicitacao' => date('Y-m-d H:i:s')
                    ));

                    $idSaque = $this->db->insert_id();

                    $this->db->where('id', $id);
                    $this->db->update('faturas', array(
                        'status' => 2,
                        'status_saque_raiz' => 1,
                        'valor_liberado' => 0,
                        'data_expiracao' => date('Y-m-d H:i:s')
                    ));

                    CreateLog($this->userid, 'Cancelamento de Contrato. Saque da raiz da fatura ID #' . $id . ' feita com sucesso. Valor da Fatura: ' . MOEDA . ' ' . number_format($row->valor, 2, ',', '.') . '. Valor a sacar ' . MOEDA . ' ' . number_format($raiz_sacar, 2, ',', '.'));
                    CreateNotification($this->userid, 'Você acabou de cancelar seu contrato e sacar a raiz do plano #' . $id . '. Em breve você receberá o seu valor na conta.');

                    return alerts($this->lang->line('saq_valor_cancelamento_ok'), 'success');
                }

                return alerts($this->lang->line('saq_valor_cancelaento_error'), 'danger');
            }

            return alerts('Cancelamento não disponível no momento.', 'danger');
        }

        return alerts($this->lang->line('eu_nao_sou_robo'), 'danger');
    }

    public function SacarRaiz($id)
    {

        if (UserInfo('saque_liberado') == 0) {
            return alerts($this->lang->line('saq_conta_nao_habilitada'), 'danger');
        }

        $pagamento_raiz = SystemInfo('pagamento_raiz');
        $taxa_saque_raiz = 0;
        $dia_semana = date('w');

        $token = $this->input->post('token', true);
        $action = $this->input->post('action', true);
        $conta = (int)$this->input->post('conta', true);

        $colunaConta = ColunaContaRecebimento($conta);
        $conta_recebimento = UserInfo($colunaConta);

        $responseRecaptcha = $this->recaptcha->verifyResponse($token, $action);

        if (isset($responseRecaptcha['success']) && $responseRecaptcha['success'] === true) {

            if (isset($responseRecaptcha['success']) && $responseRecaptcha['success'] === true) {

                /* verificar se o dia da semana é segunda ou quarta */

                if ($dia_semana != 1 && $dia_semana != 3) {
                    return alerts('Saque de Raiz disponível apenas nas segundas e quartas.', 'danger');
                }

                // if(UserInfo('cadastro_validado') == 0){

                //     return alerts('Seu cadastro não foi validado. Por favor, envie seus documentos para validar e continuar seu saque.', 'danger');
                // }

                if ($pagamento_raiz == 0) {

                    if (empty($conta_recebimento) || $conta_recebimento == '{}') {

                        return alerts($this->lang->line('saq_valor_conta_nao_selecionada'), 'danger');
                    }

                    $this->db->where('id', $id);
                    $this->db->where('id_usuario', $this->userid);
                    $this->db->where('status_saque_raiz', 0);
                    $query = $this->db->get('faturas');

                    if ($query->num_rows() > 0) {

                        $row = $query->row();

                        if ($row->quantidade_pagamentos_fazer == $row->quantidade_pagamentos_realizados) {
                            $taxa_saque_raiz = 0;
                        }

                        $raiz_sacar = $row->valor - ($row->valor * ($taxa_saque_raiz / 100));

                        $this->db->insert('saques', array(
                            'id_usuario' => $this->userid,
                            'valor_solicitado' => $row->valor,
                            'valor_receber' => $raiz_sacar,
                            'meio_recebimento' => $conta,
                            'conta_recebimento' => $conta_recebimento,
                            'tipo_saque' => 3,
                            'referencia_faturas' => json_encode(array($id => $row->valor)),
                            'detalhes' => 'Saque de Raiz do plano #' . $id,
                            'status' => 0,
                            'data_solicitacao' => date('Y-m-d H:i:s')
                        ));

                        $idSaque = $this->db->insert_id();

                        $this->db->where('id', $id);
                        $this->db->update('faturas', array(
                            'status' => 2,
                            'status_saque_raiz' => 1,
                            'data_expiracao' => date('Y-m-d H:i:s')
                        ));

                        CreateLog($this->userid, 'Solicitação de saque da raiz da fatura ID #' . $id . ' feita com sucesso. Valor da Fatura: ' . MOEDA . ' ' . number_format($row->valor, 2, ',', '.') . '. Valor a sacar ' . MOEDA . ' ' . number_format($raiz_sacar, 2, ',', '.'));
                        CreateNotification($this->userid, 'Você acabou de sacar a raiz do plano #' . $id . '. Em breve você receberá o seu valor na conta.');

                        return alerts($this->lang->line('saq_valor_saque_efetuado_ok'), 'success');
                    }
                }

                return alerts($this->lang->line('saq_valor_raiz_nao_permitida'), 'danger');
            }

            return alerts($this->lang->line('saq_raiz_nao_disponivel'), 'danger');
        }

        return alerts($this->lang->line('eu_nao_sou_robo'), 'danger');
    }

    public function MeiosDisponiveis()
    {

        $meios = SystemInfo('meios_disponiveis_saque');
        $meios = json_decode($meios, true);

        return $meios;
    }

    public function SolicitarUrgencia()
    {

        $id_saque = $this->input->post('id_saque', true);

        $totalDisponivel = $this->SaquesUrgenciaDisponiveis();

        if ($totalDisponivel > 0) {

            $this->db->where('id', $id_saque);
            $this->db->where('id_usuario', $this->userid);
            $query = $this->db->get('saques');

            if ($query->num_rows() > 0) {

                $row = $query->row();

                if ($row->status == 0) {

                    $this->db->where('id', $id_saque);
                    $this->db->update('saques', array(
                        'urgente' => 1,
                        'data_solicitacao_urgencia' => date('Y-m-d H:i:s')
                    ));

                    CreateLog($this->userid, 'Efetuou a solicitação de saque com urgência do saque ID #' . $id_saque);
                    CreateNotification($this->userid, 'Você acabou de solicitar o saque de urgência do saque ID ' . $id_saque . '. O nosso prazo para pagamento desse saque será de até 12h. Fique atento as regras desse tipo de saque.');


                    return alerts($this->lang->line('saq_urgencia_sucesso'), 'success');
                }

                return alerts($this->lang->line('saq_urgencia_status_indisponivel'), 'danger');
            }

            return alerts($this->lang->line('saq_urgencia_inexistente'), 'danger');
        }

        return alerts($this->lang->line('saq_urgencia_limite'), 'danger');
    }

    public function SaquesUrgenciaDisponiveis()
    {

        $level = UserInfo('perfil');

        $this->db->where('level', $level);
        $query = $this->db->get('levels');

        $saquesUrgenciasTotal = $query->row()->saques_urgencias;

        $this->db->where('urgente', 1);
        $this->db->where('id_usuario', $this->userid);
        $this->db->where('MONTH(data_solicitacao)', date('m'), false);
        $querySaques = $this->db->get('saques');

        $totalDisponivel = $saquesUrgenciasTotal - $querySaques->num_rows();

        return $totalDisponivel;
    }
}
