<div class="pcoded-content">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $nome_pagina; ?></h5>
        </div>
        <div class="card-body table-border-style">

            <?php if (isset($message)) echo $message; ?>

            <div class="linkContainer">
                <h2 class=""><?php echo sprintf($this->lang->line('ind_relatorio_seu_patrocinador'), $patrocinador->nome); ?></h2>
                <p class="">
                    <?php echo sprintf($this->lang->line('ind_relatorio_contato_patrocinador_ins_1'), $patrocinador->nome, date('d/m/Y \à\s H:i', strtotime(UserInfo('data_cadastro')))); ?>
                </p>
                <a class="btn btn-sm btn-secondary mb-4" href="https://api.whatsapp.com/send?phone=<?php echo str_replace(array(' ', '.', '-', '(', ')', '+'), array('', '', '', '', '', ''), $patrocinador->ddi . $patrocinador->celular); ?>&text=Olá, estou cadastrado em sua rede na <?php echo NOME_SITE; ?> e preciso de ajuda." class="m-r-30 text-muted" target="_blank"><i class="fab fa-whatsapp"></i>&nbsp; <?php echo $this->lang->line('ind_relatorio_contato_patrocinador_button'); ?></a>
                <hr>
                <p class="mb-4">
                <div class="card flat-card">
                    <div class="row">
                        <div class="col-sm-3 card-body">
                            <div class="text-center">
                                <h1><?php echo $clicksLink; ?></h1>
                                <span><?php echo $this->lang->line('ind_relatorio_cliques_link'); ?></span>
                            </div>
                        </div>
                        <div class="col-sm-3 card-body">
                            <div class="text-center">
                                <h1><?php echo $indicadosAtivos; ?></h1>
                                <span><?php echo $this->lang->line('ind_relatorio_cadastros_ativos'); ?></span>
                            </div>
                        </div>
                        <div class="col-sm-3 card-body">
                            <div class="text-center">
                                <h1><?php echo $indicadosPendentes; ?></h1>
                                <span><?php echo $this->lang->line('ind_relatorio_cadastros_pendentes'); ?></span>
                            </div>
                        </div>
                        <div class="col-sm-3 card-body">
                            <div class="text-center">
                                <h1>
                                    <?php
                                    if ($clicksLink > 0) {
                                        echo round((($indicadosAtivos * 100) / $clicksLink), 2);
                                    } else {
                                        echo '0';
                                    }
                                    ?>
                                    <sup>%</sup>
                                </h1>
                                <span><?php echo $this->lang->line('ind_relatorio_conversao'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="text" class="form-control mb-4" id="linkIndicacao" value="<?php echo base_url(); ?><?php echo $rotas->cadastro; ?>?<?php echo SystemInfo('query_string_patrocinador'); ?>=<?php echo UserInfo('codigo_patrocinio'); ?>" disabled />
                <button class="btn btn-secondary btn-block copiarLink" onclick="gtag('event','link_share', { 'event_category':'click', 'event_label':'<?php echo UserInfo('login'); ?>' })"><i data-feather="file"></i> <?php echo $this->lang->line('copiar_link_indicacao'); ?></button>
                </p>

                <div class="card-header mt-4">
                    <h5 class="text-white"><?php echo $this->lang->line('ind_relatorio_ultimos_cadastrados'); ?></h5>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><?php echo $this->lang->line('ind_relatorio_form_nome'); ?></th>
                                <th><?php echo $this->lang->line('ind_relatorio_form_celular'); ?></th>
                                <th><?php echo $this->lang->line('ind_relatorio_form_cadastro_ativo'); ?></th>
                                <th><?php echo $this->lang->line('ind_relatorio_form_data_cadastro'); ?></th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($cadastros !== false) {
                                foreach ($cadastros as $indicado) {
                            ?>
                                    <tr>
                                        <td><?php echo $indicado->nome; ?></td>
                                        <td><?php echo $indicado->celular; ?></td>
                                        <td><?php echo ($indicado->plano_ativo == 1) ? strtoupper($this->lang->line('sim')) : strtoupper($this->lang->line('nao')); ?></td>
                                        <td><?php echo date('d/m/Y H:i:s', strtotime($indicado->data_cadastro)); ?></td>
                                        <td>
                                            <a class="btn btn-sm btn-info mb-4" href="https://api.whatsapp.com/send?phone=<?php echo str_replace(array(' ', '.', '-', '(', ')', '+'), array('', '', '', '', '', ''), $indicado->ddi . $indicado->celular); ?>&text=<?php echo $this->lang->line('me_chama'); ?>"><i class="fab fa-whatsapp"></i> Whatsapp</a>
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
</div>

<?php
if ($pesquisa === false) {
?>
    <a class="btpesquisa" data-toggle="modal" data-target=".qualificar-patrocinador"></a>

    <div class="modal fade qualificar-patrocinador" tabindex="-1" role="dialog" aria-labelledby="qualify" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="qualify"><?php echo $this->lang->line('relatorio_qualifique_patrocinador'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body text-dark">
                    <p><?php echo $this->lang->line('relatorio_qualificar_patrocinador_line1'); ?></p>

                    <p><?php echo $this->lang->line('relatorio_qualificar_patrocinador_line2'); ?></p>

                    <form action="" method="post">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('relatorio_pergunta1'); ?></label> <br />
                            <input type="radio" name="contato" value="1" checked> <?php echo $this->lang->line('sim'); ?> <input type="radio" name="contato" value="0"> <?php echo $this->lang->line('nao'); ?>
                        </div>
                        <div class="form-group">
                            <label><?php echo $this->lang->line('relatorio_pergunta2'); ?></label> <br />
                            <input type="radio" name="ajuda" value="1" checked> <?php echo $this->lang->line('sim'); ?> <input type="radio" name="ajuda" value="0"> <?php echo $this->lang->line('nao'); ?>
                        </div>
                        <div class="form-group">
                            <label><?php echo $this->lang->line('relatorio_pergunta3'); ?></label> <br />
                            <input type="radio" name="investir" value="1" checked> <?php echo $this->lang->line('sim'); ?> <input type="radio" name="investir" value="0"> <?php echo $this->lang->line('nao'); ?>
                        </div>
                        <div class="form-group">
                            <label><?php echo $this->lang->line('relatorio_pergunta4'); ?></label> <br />
                            <select name="nota" class="form-control">
                                <option value="0" selected>0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><?php echo $this->lang->line('relatorio_pergunta5'); ?></label> <br />
                            <textarea name="comentario" class="form-control" rows="5"></textarea>
                        </div>
                        <button type="submit" name="qualificar" value="q" class="btn btn-secondary btn-block"><?php echo $this->lang->line('relatorio_enviar_questionario'); ?></button>
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>