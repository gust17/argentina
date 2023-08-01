<?php
class Cronmodel extends CI_Model
{

    public $rotas;

    public function __construct()
    {

        parent::__construct();

        $this->load->library('pix');
        $this->load->library('push');
        $this->load->library('coinpayments');
        $this->load->library('asaas');
        $this->rotas = MinhasRotas();
    }

    public function DarBaixa($id)
    {

        $this->db->where('id', $id);
        $this->db->update('saques', array('status' => 1));

        $this->db->select('u.email, u.celular, s.valor_receber, s.id_usuario');
        $this->db->from('saques AS s');
        $this->db->join('usuarios_cadastros AS u', 'u.id = s.id_usuario', 'inner');
        $this->db->where('s.id', $id);
        $query = $this->db->get();

        $row = $query->row();

        CreateLog($row->id_usuario, 'Deu baixa no saque ID #' . $id, true);

        CreateRegisterBox(null, 'Pagamento do saque #' . $id . ' do usuário <b>' . UserInfo('login', $row->id_usuario) . '</b>', 2, $row->valor_receber);
    }

    public function PayWithdraws()
    {

        $total = 0;
        $retornos = [];

        $this->db->where('status', 0);
        $this->db->where('data_exclusao IS NULL', null, false);
        $querySaques = $this->db->get('saques');

        if ($querySaques->num_rows() > 0) {

            foreach ($querySaques->result() as $result) {

                $valor = $result->valor_receber;
                $contaRecebimentoDecode = json_decode($result->conta_recebimento, true);
                $contaRecebimento = $contaRecebimentoDecode['pix'] ?? false;
                $type = $contaRecebimentoDecode['tipo'] ?? 'CPF';

                if ($contaRecebimento !== false) {

                    $output = $this->asaas->transferPix($contaRecebimento, $type, $valor);

                    $retornos[] = array('id_saque' => $result->id, 'output' => $output);

                    if (isset($output->id)) {
                        $total++;
                        $this->DarBaixa($result->id);
                    }
                }
            }

            return json_encode(array('total_paid' => $total, 'msg' => 'Saque pagos com sucesso!', 'retornos' => $retornos));
        }

        return json_encode(array('msg' => 'Nenhum saque efetuado até o momento'));
    }

    public function payBonification()
    {

        $pagamentoRaiz = SystemInfo('pagamento_raiz');

        $payments = 0;

        $isBusinessDay = (date('w') != 6 && date('w') != 0) ? true : false;

        $this->db->select('f.*, u.subscriber_id_push, u.celular');
        $this->db->from('faturas AS f');
        $this->db->join('usuarios_cadastros AS u', 'u.id = f.id_usuario', 'inner');
        $this->db->where('f.quantidade_pagamentos_realizados < ', 'f.quantidade_pagamentos_fazer', false);
        $this->db->where('f.data_primeiro_recebimento <= ', date('Y-m-d'));
        $this->db->where('f.status', 1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {

                /* Verifica se a fatura foi marcada para pagamento somente em dia útil */

                if ($row->dia_util == 1) {
                    if (!$isBusinessDay) {
                        break;
                    }
                }

                $this->db->select_sum('valor');
                $this->db->from('extrato');
                $this->db->where('referencia', $row->ciclo . '_fatura_' . $row->id);
                $this->db->where('tipo_saldo', 1);
                $this->db->where('categoria', 1);
                $this->db->where('id_usuario', $row->id_usuario);
                $queryExtractPaysPercent = $this->db->get();

                $totalPagoMomento = $queryExtractPaysPercent->row()->valor;

                $porcentagensPlano = json_decode($row->percentual_pago, true);
                $ultimoDiaPagamento = $row->quantidade_pagamentos_realizados;

                $proximoPagamento = $ultimoDiaPagamento + 1;

                $totalPagamentoHoje = $porcentagensPlano[$proximoPagamento];

                /* Faz o pagamento dos rendimentos diários */

                $percentPayPerDay = $totalPagamentoHoje / 100;

                if ($pagamentoRaiz == 1) {
                    $percentPayPerDay += 1;
                }

                $valuePay = ($row->valor * $percentPayPerDay) - $totalPagoMomento;

                $newValueReleased = $row->valor_liberado;

                if ($row->cortesia == 0) {
                    $newValueReleased = $newValueReleased + $valuePay;
                }
                $newValueReceived = $row->valor_recebido + $valuePay;
                $newQuantityPayments = $row->quantidade_pagamentos_realizados + 1;

                $codigo_controle = $row->ciclo . '_fatura_' . $row->id;

                $nome_plano = PlanInfo($row->id_plano, 'nome');

                $record = RegisterExtractItem(
                    $row->id_usuario,
                    'Pagamento da bonificação diária do plano ' . $nome_plano,
                    $valuePay,
                    1,
                    1,
                    $codigo_controle,
                    null,
                    $codigo_controle
                );

                if ($record > 0) {

                    $this->db->where('id', $row->id);
                    $this->db->update('faturas', array(
                        'quantidade_pagamentos_realizados' => $newQuantityPayments,
                        'valor_liberado' => $newValueReleased,
                        'valor_recebido' => $newValueReceived,
                        'data_ultimo_pagamento_feito' => date('Y-m-d H:i:s')
                    ));
                }

                /* Caso foi o último pagamento, ele expira o plano */

                if ($row->quantidade_pagamentos_fazer == $newQuantityPayments) {

                    $this->db->where('id', $row->id);
                    $this->db->update('faturas', array(
                        'status' => 2,
                        'valor_liberado' => ($newValueReleased),
                        'data_expiracao' => date('Y-m-d H:i:s')
                    ));

                    CreateNotification($row->id_usuario, 'Ahhh, que pena! Seu plano #' . $row->id . ' acabou de expirar. Continue ganhando com a ' . NOME_SITE . ', faça um novo aporte agora mesmo!');
                    CreateLog($row->id_usuario, 'O plano #' . $row->id . ' acabou de expirar.');
                }

                $payments++;
            }

            return json_encode(array(
                'status' => 1,
                'message' => 'Cron acabou de finalizar os pagamentos. Houve o pagamento de ' . $payments . ' faturas.'
            ));
        }

        return json_encode(array(
            'status' => 0,
            'message' => 'Não existe faturas a serem pagas.'
        ));
    }

    public function changeProfile()
    {

        $quantity = 0;
        $levels = [];

        $this->db->where('score_necessario > ', 0);
        $this->db->order_by('level', 'ASC');
        $queryLevels = $this->db->get('levels');

        foreach ($queryLevels->result() as $resultLevel) {

            $levels[$resultLevel->level] = $resultLevel->score_necessario;
        }

        $this->db->where('score > ', 0);
        $query = $this->db->get('usuarios_cadastros');

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {

                foreach ($levels as $level => $scoreNecessario) {

                    $this->db->where('id_usuario', $row->id);
                    $this->db->where('level', $level);
                    $this->db->where('data_exclusao IS NULL', null, false);
                    $queryHistorico = $this->db->get('levels_historico');

                    if ($queryHistorico->num_rows() <= 0) {

                        if ($row->score >= $scoreNecessario) {

                            $this->db->insert('levels_historico', array(
                                'id_usuario' => $row->id,
                                'level' => $level,
                                'data_criacao' => date('Y-m-d H:i:s')
                            ));

                            $this->db->where('id', $row->id);
                            $this->db->update('usuarios_cadastros', array(
                                'perfil' => $level
                            ));


                            CreateNotification($row->id, 'Parabéns, você acabou de subir para o level ' . $level . ', agora poderá aproveitar mais benefícios exclusivos para seu nível!');
                            CreateLog($row->id, 'O usuário subiu para o level ' . $level);



                            $quantity++;
                        }
                    } else {

                        if ($row->score < $scoreNecessario) {

                            $novoLevel = $level - 1;

                            if ($novoLevel >= 0) {

                                $rowHistorico = $queryHistorico->row();

                                $this->db->where('id', $rowHistorico->id);
                                $this->db->update('levels_historico', array(
                                    'data_exclusao' => date('Y-m-d H:i:s')
                                ));

                                $this->db->where('id', $row->id);
                                $this->db->update('usuarios_cadastros', array(
                                    'perfil' => $novoLevel
                                ));

                                CreateNotification($row->id, 'Own no! Infelizmente seu score caiu e você perdeu o seu level anterior. Faça mais ações dentro do sistema para subir de level novamente.');
                                CreateLog($row->id, 'O usuário desceu para o level ' . $novoLevel);
                            }

                            $quantity++;
                        }
                    }
                }
            }
        }

        return json_encode(array(
            'status' => 1,
            'message' => 'Atualização realizada com sucesso. Houve a atualização de ' . $quantity . ' perfils.'
        ));
    }

    // public function changeProfile(){

    //     $quantity = 0;

    //     $this->db->where('perfil', 1);
    //     $query = $this->db->get('usuarios_cadastros');

    //     if($query->num_rows() > 0){

    //         foreach($query->result() as $row){

    //             $this->db->select('COUNT(*) AS quantidade');
    //             $this->db->from('rede AS r');
    //             $this->db->join('usuarios_cadastros AS u', 'u.id = r.id_usuario', 'inner');
    //             $this->db->where('r.id_patrocinador_direto', $row->id);
    //             $this->db->where('u.plano_ativo', 1);
    //             $queryNetwork = $this->db->get();

    //             if($queryNetwork->num_rows() > 0){

    //                 $rowNetwork = $queryNetwork->row();

    //                 if($rowNetwork->quantidade >= 2){

    //                     $this->db->where('id', $row->id);
    //                     $this->db->update('usuarios_cadastros', array(
    //                         'perfil'=>2
    //                     ));

    //                     $quantity++;
    //                 }
    //             }
    //         }

    //         return json_encode(array(
    //             'status'=>1,
    //             'message'=>'Atualização realizada com sucesso. Houve a atualização de '.$quantity.' perfils.'
    //         ));
    //     }
    // }

    public function CheckPix()
    {

        $this->db->where('status', 0);
        $query = $this->db->get('transacoes_pix');

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $result) {

                $totalPaid = 0;

                $request = $this->pix->consultCharge($result->txid);

                if (isset($request['status']) && $request['status'] == 'CONCLUIDA') {

                    if (isset($request['pix'])) {

                        foreach ($request['pix'] as $data) {

                            $totalPaid += $data['valor'];
                        }
                    }

                    if ($totalPaid >= $result->valor) {

                        $this->db->where('id', $result->id);
                        $this->db->update('transacoes_pix', array('status' => 1));

                        $this->SystemModel->AtivarFatura($result->id_fatura, 'Pix', 'Pagamento via Pix Recebido automaticamente');
                    }
                }
            }
        }
    }

    public function CheckFrequence()
    {





        $dados = [];
        $usuariosGanhadores = [];

        $query = $this->db->query("SELECT ANY_VALUE(l.id_usuario) AS id_usuario, ANY_VALUE(DATE(data_criacao)) AS data_criacao, ANY_VALUE(u.score) AS score FROM usuarios_logs AS l INNER JOIN usuarios_cadastros AS u ON u.id = l.id_usuario WHERE log LIKE '%entrou no backoffice com sucesso%' AND l.data_criacao >= DATE_ADD(CURDATE(), INTERVAL -7 DAY) GROUP BY DATE(l.data_criacao), l.id_usuario");

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $result) {

                if (isset($dados[$result->id_usuario])) {

                    $dados[$result->id_usuario]['contagem']++;
                } else {
                    $dados[$result->id_usuario]['contagem'] = 1;
                    $dados[$result->id_usuario]['score'] = $result->score;
                }
            }



            if (!empty($dados)) {

                foreach ($dados as $idUser => $dadosUser) {

                    $porcentFrequence = (($dadosUser['contagem'] * 100) / 7);

                    // if($porcentFrequence >= 30){

                    $usuariosGanhadores[] = $idUser;

                    $perfil = UserInfo('perfil', $idUser);

                    $addScore = PontuacaoScore($perfil, 'acesso_diario') * $dadosUser['contagem'];

                    $this->db->where('id', $idUser);
                    $this->db->update('usuarios_cadastros', array(
                        'score' => ($dadosUser['score'] + $addScore)
                    ));



                    CreateNotification($idUser, 'Parabéns, seu score acaba de subir mais ' . $addScore . ' pontos pela frequência que você teve em logar em seu backoffice. Continue acessando todos os dias seu backoffice para ganhar mais pontos.');
                    // }
                }
            }

            // $removeScore = rand(10,30);
            // $semanaPassada = date('Y-m-d', (time() - (60*60*24*7)));

            // $query = $this->db->query("SELECT id FROM usuarios_cadastros WHERE id NOT IN ( '" . implode( "', '" , $usuariosGanhadores ). "') AND data_cadastro <= '".$semanaPassada."' ");

            // if($query->num_rows() > 0){

            //     foreach($query->result() as $result){

            //         $newScore = UserInfo('score', $result->id) - $removeScore;

            //         $this->db->where('id', $result->id);
            //         $this->db->update('usuarios_cadastros', array(
            //             'score'=>$newScore
            //         ));

            //         $this->rediscache->del('UserInfo_'.$result->id);

            //         CreateNotification($result->id, 'Seu score baixou '.$removeScore.' pontos porque sua conta não teve atividade suficiente na semana. Entre mais vezes no seu backoffice durante a semana para ir aumentando seu score.');

            //     }
            // }
        }
    }

    public function CheckCLicksLink()
    {





        $usuariosGanhadores = [];

        $query = $this->db->query("SELECT ANY_VALUE(l.id_usuario) AS id_usuario, ANY_VALUE(u.score) AS score, perfil, COUNT(*) AS total FROM usuarios_cliques_link AS l INNER JOIN usuarios_cadastros AS u ON u.id = l.id_usuario WHERE l.data_criacao >= DATE_ADD(CURDATE(), INTERVAL -10 DAY) GROUP BY l.id_usuario");

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $result) {

                $usuariosGanhadores[] = $result->id_usuario;

                $addPontuacao = PontuacaoScore($result->perfil, 'link_share');

                $this->db->where('id', $result->id_usuario);
                $this->db->update('usuarios_cadastros', array(
                    'score' => $result->score + $addPontuacao
                ));

                CreateNotification($result->id_usuario, 'Parabéns, seu score acaba de subir mais ' . $addPontuacao . ' pontos por você ter se empenhado em divulgar seu link de afiliado. Continue divulgando e suba seu score!');
            }

            // $removeScore = rand(10,50);
            // $diasPassados = date('Y-m-d', (time() - (60*60*24*10)));

            // $query = $this->db->query("SELECT id FROM usuarios_cadastros WHERE id NOT IN ( '" . implode( "', '" , $usuariosGanhadores ). "') AND data_cadastro <= '".$diasPassados."' ");

            // if($query->num_rows() > 0){

            //     foreach($query->result() as $result){

            //         $newScore = UserInfo('score', $result->id) - $removeScore;

            //         $this->db->where('id', $result->id);
            //         $this->db->update('usuarios_cadastros', array(
            //             'score'=>$newScore
            //         ));

            //         $this->rediscache->del('UserInfo_'.$result->id);

            //         CreateNotification($result->id, 'Seu score baixou '.$removeScore.' pontos porque você não atingiu um número mínimo de cliques em seu link durante alguns dias. Divulgue seu link em suas redes sociais, whatsapp, telegram e suba seu score para aproveitar todos os benefícios de nossa empresa.');

            //     }
            // }
        }
    }

    public function CheckBuyPlan()
    {





        $usuariosGanhadores = [];

        $query = $this->db->query("SELECT ANY_VALUE(f.id_usuario) AS id_usuario, ANY_VALUE(u.score) AS score FROM faturas AS f INNER JOIN usuarios_cadastros AS u ON u.id = f.id_usuario WHERE f.data_primeiro_recebimento >= DATE_ADD(CURDATE(), INTERVAL -25 DAY) GROUP BY f.id_usuario");

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $result) {

                $usuariosGanhadores[] = $result->id_usuario;
            }

            $removeScore = rand(20, 70);
            $diasPassados = date('Y-m-d', (time() - (60 * 60 * 24 * 25)));

            // $query = $this->db->query("SELECT id FROM usuarios_cadastros WHERE id NOT IN ( '" . implode( "', '" , $usuariosGanhadores ). "') AND data_cadastro <= '".$diasPassados."' ");

            // if($query->num_rows() > 0){

            //     foreach($query->result() as $result){

            //         $newScore = UserInfo('score', $result->id) - $removeScore;

            //         $this->db->where('id', $result->id);
            //         $this->db->update('usuarios_cadastros', array(
            //             'score'=>$newScore
            //         ));

            //         $this->rediscache->del('UserInfo_'.$result->id);

            //         CreateNotification($result->id, 'Seu score baixou '.$removeScore.' pontos pois você não comprou nenhum plano de nossa empresa nos últimos dias. Não perca mais seu score, compre um plano e acesse benefícios exclusivos de ganhos.');

            //     }
            // }
        }
    }

    public function CheckAddressProfile()
    {

        $query = $this->db->query("SELECT id, score, perfil FROM usuarios_cadastros WHERE cep != '' AND endereco != '' AND cidade != '' AND estado != ''");

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $result) {

                $addScore = PontuacaoScore($result->perfil, 'atualizacao_cadastral');

                $this->db->where('id', $result->id);
                $this->db->update('usuarios_cadastros', array(
                    'score' => $result->score + $addScore
                ));

                CreateNotification($result->id, 'Seu score aumentou ' . $addScore . ' pontos pelo seu cadastro está com seu endereço atualizado. Continue com ele atualizado para ganhar mais score!');
            }
        }
    }

    public function PaySalary()
    {

        $this->load->model('indicados/Indicadosmodel', 'IndicadosModel');

        $this->db->where('perfil >=', '4');
        $query = $this->db->get('usuarios_cadastros');

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $result) {

                $redeUnilevel = array();

                $this->IndicadosModel->createUnilevel($result->id, 1, 5);

                $usersUnilevel = $this->IndicadosModel->getUsersUnilevel();

                foreach ($usersUnilevel as $nivel => $vUsers) {

                    foreach ($vUsers as $dadosUsersUnilevel) {

                        $redeUnilevel[] = $dadosUsersUnilevel['id_usuario'];
                    }
                }

                $ultimos7dias = date('Y-m-d', (time() - (60 * 60 * 24 * 7)));
                $dataAtual = date('Y-m-d');

                $totalAcumulado = 0;

                if (count($redeUnilevel) > 0) {

                    foreach ($redeUnilevel as $idUser) {

                        $queryFaturasUser = $this->db->query("SELECT SUM(valor) AS total FROM faturas WHERE status = 1 AND data_ativacao BETWEEN '" . $ultimos7dias . "' AND '" . $dataAtual . "' AND id_usuario = '" . $idUser . "'");

                        if ($queryFaturasUser->num_rows() > 0) {

                            $rowFaturasUser = $queryFaturasUser->row();

                            $totalAcumulado += $rowFaturasUser->total;
                        }
                    }
                }

                if ($totalAcumulado > 0) {

                    $totalPagar = $totalAcumulado * (3 / 100);

                    RegisterExtractItem(
                        $result->id_usuario,
                        'Pagamento do salário vitálicio semanal de 3% sobre sua rede unilevel',
                        $totalPagar,
                        1,
                        2
                    );

                    CreateNotification($result->id, 'Seu salário foi pago com sucesso. Você recebeu ' . MOEDA . ' ' . $totalPagar . ' de salário vitálicio semanal.');
                } else {

                    CreateNotification($result->id, 'Essa semana sua rede unilevel não movimentou nenhum valor, por esse motivo você não recebeu o salário vitálicio semanal.');
                }
            }
        }
    }

    public function ClearRedis()
    {
    }
}
