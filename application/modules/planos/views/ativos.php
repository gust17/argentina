<div class="pcoded-content">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('plan_ativos_titulo'); ?></h5>
        </div>
        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo $this->lang->line('plan_ativos_form_plano'); ?></th>
                            <th><?php echo $this->lang->line('plan_ativos_form_ganhos'); ?></th>
                            <th><?php echo $this->lang->line('plan_ativos_form_dias_rendidos'); ?></th>
                            <th><?php echo $this->lang->line('plan_ativos_form_pago_com'); ?></th>
                            <th><?php echo $this->lang->line('plan_ativos_form_data_ativacao'); ?></th>
                            <th><?php echo $this->lang->line('plan_ativos_form_primeiro_recebimento'); ?></th>
                            <th><?php echo $this->lang->line('plan_ativos_form_acao'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($planos !== false) {
                            foreach ($planos as $plano) {
                        ?>
                                <tr>
                                    <td><?php echo $plano->id; ?></td>
                                    <td><?php echo $plano->nome; ?> (<?php echo MOEDA; ?> <?php echo number_format($plano->valor, 2, ',', '.'); ?>)</td>
                                    <td><?php echo MOEDA; ?> <?php echo number_format($plano->valor_recebido, 2, ',', '.'); ?></td>
                                    <td>
                                        <div class="progress">
                                            <?php
                                            $porcentagem = round((($plano->quantidade_pagamentos_realizados * 100) / $plano->quantidade_pagamentos_fazer), 2);
                                            ?>
                                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $porcentagem; ?>%;" aria-valuenow="<?php echo $porcentagem; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $plano->quantidade_pagamentos_realizados; ?>/<?php echo $plano->quantidade_pagamentos_fazer; ?></div>
                                        </div>
                                    </td>
                                    <td><?php echo $plano->meio_pagamento; ?></td>
                                    <td><?php echo date('d/m/Y H:i:s', strtotime($plano->data_pagamento)); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($plano->data_primeiro_recebimento)); ?></td>
                                    <td>
                                        <?php
                                        if ($plano->quantidade_pagamentos_realizados > 0) {
                                            $rotaSaque = str_replace(array('(:num)', '(:any)'), array($plano->id, $plano->id), $rotas->saques_rendimento);
                                        ?>
                                            <a href="<?php echo base_url($rotaSaque); ?>" class="btn btn-success"><?php echo $this->lang->line('planos_ativos_sacar_rendimento'); ?></a>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if ($cancelamento_contrato == 1 && $paga_raiz_rendimento == 0 && $plano->status_saque_raiz == 0) {

                                            $rotaCancelamento = str_replace(array('(:num)', '(:any)'), array($plano->id, $plano->id), $rotas->cancelar_contrato);
                                        ?>
                                            <a href="<?php echo base_url($rotaCancelamento); ?>" class="btn btn-sm btn-danger"><?php echo $this->lang->line('plan_ativos_cancelar_contrato'); ?></a>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>