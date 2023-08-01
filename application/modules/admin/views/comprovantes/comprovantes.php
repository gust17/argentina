<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Visão Geral - <?php echo $nome_pagina; ?></h4>
                <p class="card-title-desc">Encontre abaixo uma tabela com a <?php echo $nome_pagina; ?></p>

                <div>

                    <?php if ($this->session->flashdata('comprovantes_message')) echo $this->session->flashdata('comprovantes_message'); ?>

                    <div class="table-responsive">
                        <?php
                        if ($comprovantes !== false) {
                        ?>
                            <table id="" class="table table-striped simpletable_order_by_0_desc">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Login</th>
                                        <th>Banco</th>
                                        <th>Plano</th>
                                        <th>Documento</th>
                                        <th>Status</th>
                                        <th>Data do Envio</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($comprovantes as $comprovante) {

                                        $rotaComprovantesAtivar = str_replace(array('(:num)', '(:any)'), array($comprovante->id, $comprovante->id), $rotas->admin_comprovantes_aprovar);
                                        $rotaComprovantesRejeitar = str_replace(array('(:num)', '(:any)'), array($comprovante->id, $comprovante->id), $rotas->admin_comprovantes_rejeitar);
                                        $rotaComprovantesExcluir = str_replace(array('(:num)', '(:any)'), array($comprovante->id, $comprovante->id), $rotas->admin_comprovantes_excluir);

                                    ?>
                                        <tr>
                                            <th><?php echo $comprovante->id; ?></th>
                                            <td><?php echo $comprovante->login; ?></td>
                                            <td>
                                                <?php
                                                if ($comprovante->banco != 'bbva' && $comprovante->banco != 'bcp' && $comprovante->banco != 'pix') {
                                                    echo BancoID($comprovante->banco);
                                                } else if ($comprovante->banco == 'bbva') {
                                                    echo 'BBVA';
                                                } else if ($comprovante->banco == 'bcp') {
                                                    echo 'BCP';
                                                } else {
                                                    echo $comprovante->banco;
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $comprovante->nome_plano; ?> (<?php echo MOEDA; ?> <?php echo number_format($comprovante->valor, 2, ',', '.'); ?>)</td>
                                            <td>
                                                <a href="<?php echo $comprovante->comprovante; ?>" target="_blank" data-id="<?php echo $comprovante->id; ?>" data-login="<?php echo $comprovante->login; ?>" class="btn btn-info visualizarComprovante">Comprovante</a>
                                            </td>
                                            <td>
                                                <?php
                                                if ($comprovante->status == 0) {
                                                    $text = 'Pendente';
                                                    $color = 'warning';
                                                } elseif ($comprovante->status == 1) {
                                                    $text = 'Ativado';
                                                    $color = 'success';
                                                } else {
                                                    $text = 'Rejeitado';
                                                    $color = 'danger';
                                                }
                                                ?>
                                                <span class="badge badge-<?php echo $color; ?>"><?php echo $text; ?></span>
                                            </td>
                                            <td><?php echo date('d/m/Y H:i:s', strtotime($comprovante->data_atualizacao)); ?></td>
                                            <td>

                                                <?php
                                                if (EnabledMasterKey()) {
                                                ?>


                                                    <?php
                                                    if ($comprovante->status == 0) {
                                                    ?>
                                                        <?php
                                                        if ($permitidoAtivar) {
                                                        ?>
                                                            <a href="<?php echo base_url($rotaComprovantesAtivar); ?>" class="btn btn-success">Ativar</a>
                                                        <?php
                                                        }
                                                        ?>

                                                        <?php
                                                        if ($permitidoRejeitar) {
                                                        ?>
                                                            <a href="<?php echo base_url($rotaComprovantesRejeitar); ?>" class="btn btn-warning rejeitarComprovante">Rejeitar</a>
                                                        <?php
                                                        }
                                                        ?>

                                                    <?php
                                                    }
                                                    ?>

                                                    <?php
                                                    if ($permitidoExcluir) {
                                                    ?>
                                                        <a href="<?php echo base_url($rotaComprovantesExcluir); ?>" class="btn btn-danger">Excluir</a>
                                                    <?php
                                                    }
                                                    ?>

                                                <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        <?php
                        } else {
                            echo alerts('Não há nenhum comprovante enviado no momento.', 'info');
                        }
                        ?>
                    </div>

                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->