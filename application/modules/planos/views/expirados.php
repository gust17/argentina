<div class="pcoded-content">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('plan_expirados_titulo'); ?></h5>
        </div>
        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo $this->lang->line('plan_expirados_form_plano'); ?></th>
                            <th><?php echo $this->lang->line('plan_expirados_form_ganhos'); ?></th>
                            <th><?php echo $this->lang->line('plan_expirados_form_pago_com'); ?></th>
                            <th><?php echo $this->lang->line('plan_expirados_form_data_ativacao'); ?></th>
                            <th><?php echo $this->lang->line('plan_expirados_form_data_expiracao'); ?></th>
                            <th><?php echo $this->lang->line('plan_expirados_form_acao'); ?></th>
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
                                    <td><?php echo $plano->meio_pagamento; ?></td>
                                    <td><?php echo date('d/m/Y H:i:s', strtotime($plano->data_pagamento)); ?></td>
                                    <td><?php echo date('d/m/Y H:i:s', strtotime($plano->data_expiracao)); ?></td>
                                    <td>

                                        <?php
                                        if ($this->SystemModel->RendimentoDisponivelFatura($plano->id) > 0) {
                                            $rotaSaque = str_replace(array('(:num)', '(:any)'), array($plano->id, $plano->id), $rotas->saques_rendimento);
                                        ?>
                                            <a href="<?php echo base_url($rotaSaque); ?>" class="btn btn-success"><?php echo $this->lang->line('planos_ativos_sacar_rendimento'); ?></a>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if ($paga_raiz_rendimento == 0 && $plano->status_saque_raiz == 0) {
                                            $rotaRaiz = str_replace(array('(:num)', '(:any)'), array($plano->id, $plano->id), $rotas->sacar_raiz);
                                        ?>
                                            <a href="<?php echo base_url($rotaRaiz); ?>" class="btn btn-sm btn-secondary"><?php echo $this->lang->line('plan_expirados_sacar_raiz_button'); ?></a>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-success renovarContrato" data-id="<?php echo $plano->id; ?>"><?php echo $this->lang->line('plan_expirados_renovar_button'); ?></a>
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