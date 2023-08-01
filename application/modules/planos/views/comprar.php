<div class="pcoded-content">

    <?php if (isset($message)) echo $message; ?>

    <div class="row">


        <?php
        foreach ($planos1 as $plano) {
        ?>
            <div class="col-md-3">
                <div class="card card-dashboard">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-4 text-left">
                                <?php $plano->nome; ?>
                            </div>
                            <div class="col-8 text-right">
                                <img src="<?php echo base_url('assets/cliente/default/assets/images/icone-pix.svg') ?>" width="16" height="16" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <small><?php echo $this->lang->line('plan_investimento'); ?></small>
                                <h4 class="text-secondary">R$ <?php echo number_format($plano->valor, 2, ',', '.'); ?></h4>
                            </div>
                            <div class="col-6">
                                <small><?php echo $this->lang->line('plan_retorno'); ?></small>
                                <h4 class="text-secondary">R$ <?php echo number_format($plano->valor, 2, ',', '.'); ?></h4>
                            </div>
                            <div class="col-12">
                                <small><?php echo $this->lang->line('plan_prazo'); ?></small>
                                <h5 class="text-secondary"><?php echo $plano->quantidade_dias; ?> <?php echo $this->lang->line('dias'); ?></h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-right pt-4">
                                <small class="mr-2">
                                    <img src="<?php echo base_url('assets/cliente/default/assets/images/menu-icons/check.svg') ?>" width="16" height="16" alt="" class="img-fluid">
                                    <?php echo $this->lang->line('plan_pacote_disponivel'); ?>
                                </small>

                                <form action="" method="post">
                                    <button type="submit" name="submit" value="Gerar Fatura" load-button="on" load-text="<?php echo $this->lang->line('plan_gerarando_fatura_button'); ?>" class="btn btn-sm btn-secondary"><small class="fas fa-hryvnia"></small> <?php echo $this->lang->line('plan_gerar_fatura_button'); ?></button>
                                    <input type="hidden" name="id_plano" value="<?php echo $plano->id; ?>" />
                                    <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>" />
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>

    </div>
</div>