<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title"><?php echo $nome_pagina; ?></h4>
                <p class="card-title-desc">Informações sobre o saque</p>

                <?php
                $rotaSaqueBaixa = str_replace(array('(:num)', '(:any)'), array($saque->id, $saque->id), $rotas->admin_saques_baixa);
                $rotaSaqueEstorno = str_replace(array('(:num)', '(:any)'), array($saque->id, $saque->id), $rotas->admin_saques_estornar);
                $rotaSaqueExcluir = str_replace(array('(:num)', '(:any)'), array($saque->id, $saque->id), $rotas->admin_saques_excluir);

                if (EnabledMasterKey()) {

                    if ($saque->status == 0) {
                ?>

                        <?php
                        if ($permitidoBaixa) {
                        ?>
                            <a href="<?php echo base_url($rotaSaqueBaixa); ?>" class="btn btn-info">Dar Baixa</a>
                        <?php
                        }
                        ?>

                        <?php
                        if ($permitidoEstornar) {
                        ?>
                            <a href="<?php echo base_url($rotaSaqueEstorno); ?>" class="btn btn-warning estornarSaque">Estornar Saque</a>
                        <?php
                        }
                        ?>

                    <?php
                    }
                    ?>

                    <?php
                    if ($permitidoExcluir) {
                    ?>
                        <a href="<?php echo base_url($rotaSaqueExcluir); ?>" class="btn btn-danger">Excluir Saque</a>
                    <?php
                    }
                    ?>


                <?php
                }
                ?>

                <div class="mt-4">
                    <div class="table-responsive">
                        <?php
                        if ($saque !== false) {
                        ?>
                            <table id="" class="table table-striped simpletable">
                                <tbody>
                                    <tr>
                                        <td>Nome</td>
                                        <td><?php echo UserInfo('nome', $saque->id_usuario); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Login</td>
                                        <td><?php echo UserInfo('login', $saque->id_usuario); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Valor Solicitado</strong></td>
                                        <td><?php echo MOEDA; ?> <?php echo number_format($saque->valor_solicitado, 2, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Valor a Receber</strong></td>
                                        <td><?php echo MOEDA; ?> <?php echo number_format($saque->valor_receber, 2, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Meio de Recebimento</td>
                                        <td><?php echo MeioRecebimento($saque->meio_recebimento); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tipo de Saque</td>
                                        <td><?php echo CategoriaExtrato($saque->tipo_saque); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Detalhes de controle</td>
                                        <td><?php echo $saque->detalhes; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>
                                            <?php
                                            if ($saque->status == 0) {
                                                $text = 'Pendente';
                                                $color = 'warning';
                                            } elseif ($saque->status == 1) {
                                                $text = 'Pago';
                                                $color = 'success';
                                            } else {
                                                $text = 'Estornado';
                                                $color = 'danger';
                                            }
                                            ?>
                                            <span class="badge badge-<?php echo $color; ?>"><?php echo $text; ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Data de Solicitação</td>
                                        <td><?php echo date('d/m/Y H:i:s', strtotime($saque->data_solicitacao)); ?></td>
                                    </tr>
                                    <?php
                                    if ($saque->urgente == 1) {
                                    ?>
                                        <tr>
                                            <td>Data de Solicitação da urgência</td>
                                            <td><?php echo date('d/m/Y H:i:s', strtotime($saque->data_solicitacao_urgencia)); ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if ($saque->urgente == 0) {
                                    ?>
                                        <tr>
                                            <td>Data limite para pagamento</td>
                                            <td>
                                                <?php
                                                $dataDiasUteis = DiasUteis($saque->data_solicitacao, $dias_pagamento_saque);
                                                $horarioSolicitacao = date('H:i:s', strtotime($saque->data_solicitacao));

                                                echo date('d/m/Y', strtotime($dataDiasUteis)) . ' ' . $horarioSolicitacao;
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                    } else {
                                    ?>
                                        <tr>
                                            <td>Data limite para pagamento (PRAZO URGENTE)</td>
                                            <td>
                                                <?php
                                                echo date('d/m/Y H:i:s', strtotime($saque->data_solicitacao_urgencia) + (60 * 60 * SystemInfo('prazo_saque_urgencia')));
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    <tr>
                                        <td><strong><span class="text-success">Dados para pagamento</span></strong></td>
                                        <td>
                                            <?php
                                            $meio = json_decode($saque->conta_recebimento);

                                            if ($saque->meio_recebimento == 1) {

                                                if (!empty($meio->bankon)) {
                                                    echo $meio->bankon;
                                                }
                                            } elseif ($saque->meio_recebimento == 2) {

                                                if (!empty($meio->newpay)) {
                                                    echo $meio->newpay;
                                                }
                                            } elseif ($saque->meio_recebimento == 3) {

                                                if (!empty($meio->conta)) {
                                                    echo 'Banco: ' . BancoID($meio->banco) . '<br />';
                                                    echo 'AG: ' . $meio->agencia . '<br />';
                                                    echo 'Conta: ' . $meio->conta . '<br />';
                                                    echo 'Tipo de Conta: ' . ($meio->tipo == 1) ? 'Conta Corrente' : 'Conta Poupança' . '<br />';
                                                    echo 'Titular: ' . $meio->titular . '<br />';
                                                    echo 'Documento: ' . $meio->documento . '<br />';
                                                }
                                            } elseif ($saque->meio_recebimento == 4) {

                                                if (!empty($meio->carteira_bitcoin)) {
                                                    echo $meio->carteira_bitcoin;
                                                }
                                            } elseif ($saque->meio_recebimento == 5) {

                                                if (!empty($meio->pix)) {
                                                    echo '<h5><span class="badge badge-primary"><i class="fa fa-key"></i> Chave Pix: ' . $meio->pix . '</span></h5>';
                                                    echo '<h5><span class="badge badge-secondary"><i class="fa fa-home"></i> Tipo: ' . $meio->tipo . '</span></h5> <br />';
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php
                        } else {
                            echo alerts('Não foi possível encontrar nenhum saque com os critérios informados.', 'info');
                        }
                        ?>
                    </div>

                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->