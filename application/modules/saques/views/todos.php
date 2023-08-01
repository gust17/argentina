<div class="pcoded-content">
    <div class="mb-4">
        <!-- slider -->
        <div id="app">
            <!-- Fashion slider container -->
            <div class="fashion-slider d-none mt-4">
                <div class="swiper">
                    <div class="swiper-wrapper">

                        <!-- configure slide color with "data-slide-bg-color" attribute -->
                        <div class="swiper-slide" data-slide-bg-color="#071126">
                            <!-- slide title wrap -->
                            <div class="fashion-slider-title" data-swiper-parallax="-130%">
                                <!-- slide title text -->
                                <div class="fashion-slider-title-text pt-4">
                                    <h2 class="text-white is-size-4"><?php echo $this->lang->line('saq_todos_saques_totais'); ?></h2>
                                    <span class="font-serif"><?php echo MOEDA; ?> <?php echo number_format($solicitacao_total, 2, ',', '.'); ?></span>
                                    <p>
                                        <span class="is-size-4"><?php echo $this->lang->line('saq_todos_saques_totais_desc'); ?></span> &nbsp;
                                        <br>
                                        <img src="<?php echo base_url('assets/cliente/default/assets/images/logo-white.png') ?>" width="125" height="25" alt="" class="img-fluid mt-4"> <br>
                                    </p>
                                </div>
                            </div>
                            <!-- slide image wrap -->
                            <div class="fashion-slider-scale"><img src="<?php echo base_url(''); ?>/assets/pages/backoffice/bgplanos.jpg"></div>
                        </div>
                        <!-- configure slide color with "data-slide-bg-color" attribute -->
                        <div class="swiper-slide" data-slide-bg-color="#071126">
                            <!-- slide title wrap -->
                            <div class="fashion-slider-title" data-swiper-parallax="-130%">
                                <!-- slide title text -->
                                <div class="fashion-slider-title-text pt-4">
                                    <h2 class="text-white is-size-4"><?php echo $this->lang->line('saq_todos_saques_pagos'); ?></h2>
                                    <span class="font-serif"><?php echo MOEDA; ?> <?php echo number_format($solicitacao_paga, 2, ',', '.'); ?></span>
                                    <p>
                                        <span class="is-size-4"><?php echo $this->lang->line('saq_todos_saques_pagos_desc'); ?></span> &nbsp;
                                        <br>
                                        <img src="<?php echo base_url('assets/cliente/default/assets/images/logo-white.png') ?>" width="125" height="25" alt="" class="img-fluid mt-4"> <br>
                                    </p>
                                </div>
                            </div>
                            <!-- slide image wrap -->
                            <div class="fashion-slider-scale"><img src="<?php echo base_url(''); ?>/assets/pages/backoffice/bgrendimentos.jpg"></div>
                        </div>

                    </div>
                    <!-- right/next navigation button -->
                    <div class="fashion-slider-button-prev fashion-slider-button">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 350 160 90">
                            <g class="fashion-slider-svg-wrap">
                                <g class="fashion-slider-svg-circle-wrap">
                                    <circle cx="42" cy="42" r="40"></circle>
                                </g>
                                <path class="fashion-slider-svg-arrow" d="M.983,6.929,4.447,3.464.983,0,0,.983,2.482,3.464,0,5.946Z">
                                </path>
                                <path class="fashion-slider-svg-line" d="M80,0H0"></path>
                            </g>
                        </svg>
                    </div>
                    <!-- left/previous navigation button -->
                    <div class="fashion-slider-button-next fashion-slider-button">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 350 160 90">
                            <g class="fashion-slider-svg-wrap">
                                <g class="fashion-slider-svg-circle-wrap">
                                    <circle cx="42" cy="42" r="40"></circle>
                                </g>
                                <path class="fashion-slider-svg-arrow" d="M.983,6.929,4.447,3.464.983,0,0,.983,2.482,3.464,0,5.946Z">
                                </path>
                                <path class="fashion-slider-svg-line" d="M80,0H0"></path>
                            </g>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <!-- .slider -->
    </div>
    <div class="card">
        <div class="card-header">
            <h5><?php echo $nome_pagina; ?></h5>
        </div>
        <div class="card-body table-border-style">
            <div class="table-responsive dt-responsive">
                <table class="table simpletable_order_by_0_desc">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo $this->lang->line('saq_todos_form_tipo_saque'); ?></th>
                            <th><?php echo $this->lang->line('saq_todos_form_status_saque'); ?></th>
                            <th><?php echo $this->lang->line('saq_todos_form_valor_solicitado'); ?></th>
                            <th><?php echo $this->lang->line('saq_todos_form_valor_receber'); ?></th>
                            <th><?php echo $this->lang->line('saq_todos_form_data_solicitacao'); ?></th>
                            <th><?php echo $this->lang->line('saq_todos_form_limite_recebimento'); ?></th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($saques !== false) {
                            foreach ($saques as $saque) {

                                if ($saque->urgente == 0) {
                                    $dataDiasUteis = DiasUteis($saque->data_solicitacao, $dias_pagamento_saque);
                                    $horarioSolicitacao = date('H:i:s', strtotime($saque->data_solicitacao));

                                    $dataLimite = date('Y/m/d', strtotime($dataDiasUteis)) . ' ' . $horarioSolicitacao;
                                } else {

                                    $dataLimite = date('Y/m/d H:i:s', strtotime($saque->data_solicitacao_urgencia) + (60 * 60 * SystemInfo('prazo_saque_urgencia')));
                                }
                        ?>
                                <tr>
                                    <td><?php echo $saque->id; ?></td>
                                    <td><?php echo CategoriaExtrato($saque->tipo_saque); ?></td>
                                    <td><?php echo StatusSaque($saque->status); ?></td>
                                    <td><?php echo MOEDA; ?> <?php echo number_format($saque->valor_solicitado, 2, ',', '.'); ?></td>
                                    <td><?php echo MOEDA; ?> <?php echo number_format($saque->valor_receber, 2, ',', '.'); ?></td>
                                    <td><?php echo date('d/m/Y H:i:s', strtotime($saque->data_solicitacao)); ?></td>
                                    <td><span class="countdown" data-final="<?php echo $dataLimite; ?>"></span></td>
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