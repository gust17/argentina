<div class="pcoded-content" style="margin-top:0 !important">

    <div class="row">
        <div class="col-md-12">
            <div class="card feed-card">
                <div class="card-body p-t-0 p-b-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="p-t-25 p-b-25">
                                <h2 class="f-w-400 m-b-10">
                                    <button class="btn btn-danger btn-block text-uppercase copiarLink"><i data-feather="file"></i> <?php echo $this->lang->line('copiar_link_indicacao'); ?></button>
                                </h2>
                                <p class="text-muted m-0">
                                    <span class="text-danger f-w-400">
                                        <input type="text" class="form-control" id="linkIndicacao" value="<?php echo base_url(); ?><?php echo $rotas->cadastro; ?>?<?php echo SystemInfo('query_string_patrocinador'); ?>=<?php echo UserInfo('codigo_patrocinio'); ?>" disabled />
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dashboard" style="height:649px">
                <div class="card-header">
                    <?php echo $this->lang->line('resumo'); ?>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="badge badge-info mb-4">
                                <b><?php echo $this->lang->line('rendimentos'); ?></b>
                                <small><?php echo $this->lang->line('habilitado'); ?></small>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                            <small class=""><?php echo $this->lang->line('total'); ?></small>
                            <h2 class="text-secondary">
                                <b>S/. <?php echo number_format($saldoRendimento, 2, ',', '.'); ?></b>
                            </h2>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                            <small class=""><?php echo $this->lang->line('entradas'); ?></small>
                            <h2 class="text-secondary">
                                <b>S/. <?php echo number_format($this->SystemModel->BalancoSaldo(1, 1), 2, ',', '.'); ?></b>
                            </h2>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                            <small class=""><?php echo $this->lang->line('saidas'); ?></small>
                            <h2 class="text-secondary">
                                <b>S/. <?php echo number_format($this->SystemModel->BalancoSaldo(2, 1), 2, ',', '.'); ?></b>
                            </h2>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="badge badge-info mb-4">
                                <b><?php echo $this->lang->line('rede'); ?></b>
                                <small><?php echo $this->lang->line('habilitado'); ?></small>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                            <small class=""><?php echo $this->lang->line('total'); ?></small>
                            <h2 class="text-secondary">
                                <b>S/. <?php echo number_format($saldoRede, 2, ',', '.'); ?></b>
                            </h2>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                            <small class=""><?php echo $this->lang->line('entradas'); ?></small>
                            <h2 class="text-secondary">
                                <b>S/. <?php echo number_format($this->SystemModel->BalancoSaldo(1, 2), 2, ',', '.'); ?></b>
                            </h2>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                            <small class=""><?php echo $this->lang->line('saidas'); ?></small>
                            <h2 class="text-secondary">
                                <b>S/. <?php echo number_format($this->SystemModel->BalancoSaldo(2, 2), 2, ',', '.'); ?></b>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card card-dashboard">
                <div class="card-header">
                    <?php echo $this->lang->line('resumo_afiliados'); ?>
                </div>
                <div class="card-body">
                    <div class="row pt-2">
                        <div class="col-sm-3 text-left">
                            <h2 class="font-light" id="blockTotalRede">
                                <span class="font-light"><?php echo $this->lang->line('cadastrados'); ?></span>
                                <span class="ml-1 text-secondary font-light"><?php echo $infoUnilevel['total']; ?></span>
                            </h2>
                        </div>
                        <div class="col-sm-3 text-left">
                            <h2 class="" id="blockDiretosRede">
                                <span class="font-light"><?php echo $this->lang->line('diretos'); ?></span>
                                <span class="ml-1 text-secondary font-light"><?php echo $infoUnilevel['diretos']; ?></span>
                            </h2>
                        </div>
                        <div class="col-sm-3 text-left">
                            <h2 class="" id="blockAtivosRede">
                                <span class="font-light"><?php echo $this->lang->line('ativos'); ?></span>
                                <span class="ml-1 text-secondary font-light"><?php echo $infoUnilevel['ativos']; ?></span>
                            </h2>
                        </div>
                        <div class="col-sm-3 text-left">
                            <h2 class="" id="blockPendentesRede">
                                <span class="font-light"><?php echo $this->lang->line('pendentes'); ?></span>
                                <span class="ml-1 text-secondary font-light"><?php echo $infoUnilevel['pendentes']; ?></span>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row pt-0 d-none">
        <div class="col-md-12">
            <div class="page-header">
                <div class="page-block text-right">
                    <div class="page-header-title">
                        <h5 class="m-b-10"><?php echo $nome_pagina; ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    if ($modalStatus == 1) {
    ?>
        <div class="modal fade modal-aviso" tabindex="-1" role="dialog" aria-labelledby="avisoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title h4" id="avisoModalLabel"><?php echo $this->lang->line('atencao'); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <?php echo SystemInfo('modal_backoffice_editor'); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

    <!-- Javascript need page -->
    <script>
        var paymentBusinessDay = '<?php echo SystemInfo('rendimento_dias_uteis'); ?>';
        var horaRendimento = '<?php echo SystemInfo('rendimento_hora'); ?>';
    </script>


    <style>
        html.lightTheme.br body div#siteWrapper.siteWrapper header.topRoundCorners div.mainHeader {
            display: none !important
        }

        html.lightTheme.br body div#siteWrapper.siteWrapper header.topRoundCorners div.widgetTitle {
            display: none !important
        }
    </style>