<div class="pcoded-content">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $nome_pagina;?></h5>
        </div>

        <div class="row">
            <div class="col-md-8">
                <form class="row mt-3 m-3" method="get" action="" enctype="multipart/form-data">
                    <div class="form-group col-md-9">
                        <input type="text" placeholder="<?php echo $this->lang->line('ind_binario_login_usuario');?>" name="search" id="search" class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                        <button type="submit" class="btn btn-block btn-success"><?php echo $this->lang->line('ind_binario_buscar_button');?></button>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="form-group col-md-12">
                        <button class="btn btn-warning button_chave_binary float-right m-3" data-toggle="modal" data-target="#chaveBinaria"><i class="fa fa-key"></i> <?php echo $this->lang->line('ind_binario_mudar_chave_binaria_button');?></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row stats-row tour-block-points">
            <div class="col-lg-6 col-md-12">
                <div class="card card-transparent stats-card">
                    <div class="card-body">
                        <div class="stats-info">
                            <h5 class="card-title"><?php echo number_format(0, 0, '.', '.');?> <?php echo $this->lang->line('ind_binario_pontos');?></h5>
                            <p class="stats-text"><?php echo $this->lang->line('ind_binario_lado_esquerdo');?></p>
                            <?php
                            if(2 < 1){
                            ?>
                            <span class="badge badge-pill badge-success">
                                <i class="fas fa-network-wired"></i> <?php echo strtoupper($this->lang->line('ind_binario_perna_menor'));?>
                            </span>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="stats-icon">
                            <i class="lni-arrow-left-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="card card-transparent stats-card">
                    <div class="card-body">
                        <div class="stats-info">
                            <h5 class="card-title"><?php echo number_format(0, 0, '.', '.');?> <?php echo $this->lang->line('ind_binario_pontos');?></h5>
                            <p class="stats-text"><?php echo $this->lang->line('ind_binario_lado_direito');?></p>
                            <?php
                            if(1 < 2){
                            ?>
                            <span class="badge badge-pill badge-success">
                                <i class="fas fa-network-wired"></i> <?php echo strtoupper($this->lang->line('ind_binario_perna_menor'));?>
                            </span>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="stats-icon">
                            <i class="lni-arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body table-border-style">

            <?php
            if($redeHabilitada == 1){
            ?>
            <div class="table-responsive binary_tree" style="text-align: center">

            <?php echo $matriz; ?>

            </div>
            <?php
            }else{
                echo alerts($this->lang->line('ind_binario_matriz_nao_existe_np'), 'danger');
            }
            ?>
        </div>
    </div>
</div>


<script>
var urlBinario = '<?php echo $rotas->rede_binaria;?>';
</script>

<?php
$binaryKey = UserInfo('chave_binaria');
$binaryKeyLabel = LadoChaveBinaria($binaryKey);
?>
<div class="modal fade" id="chaveBinaria" tabindex="-1" role="dialog" aria-labelledby="modalChaveBinaria" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id=""><?php echo $this->lang->line('ind_binario_modal_chave_binaria_titulo');?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="contentNotice">
                <p class="text-center"><?php echo $this->lang->line('ind_binario_modal_chave_binaria_inst');?></p>
                <p><i class="lni-pin"></i> <?php echo $this->lang->line('ind_binario_modal_chave_binaria_posicao_atual');?> <b id="ladoAtual"><?php echo $binaryKeyLabel;?></b></p>
                <p>
                    <div class="form-group row mb-3">
                        <label class="col-3 col-form-label"><?php echo $this->lang->line('ind_binario_modal_chave_binaria_novo_lado');?></label>
                        <div class="col-9">
                            <select class="form-control binaryKeySelect">
                                <option value="1" <?php echo ($binaryKey == 1) ? 'selected' : '';?>><?php echo $this->lang->line('ind_binario_lado_esquerdo');?></option>
                                <option value="2" <?php echo ($binaryKey == 2) ? 'selected' : '';?>><?php echo $this->lang->line('ind_binario_lado_direito');?></option>
                            </select>
                        </div>
                    </div>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo $this->lang->line('fechar');?></button>
                <button type="button" class="btn btn-success saveBinaryKey" data-dismiss="modal"><?php echo $this->lang->line('ind_binario_modal_chave_binaria_alterar_button');?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAffiliate" tabindex="-1" role="dialog" aria-labelledby="modalAffiliateTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id=""><?php echo $this->lang->line('ind_binario_modal_afiliado_titulo');?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="">
                
                <div align="center" class="loading_block">
                    <i class="fa fa-spinner fa-spin fa-4x"></i>
                </div>

                <div class="content_affiliate_block" style="display:none;">

                    <div align="center">
                        <img src="" class="affiliatePhoto" style="width:80px;" /> <br />

                        <span class="badge affiliateStatusAccount"></span>
                        <span class="badge affiliateStatusBinary"></span>

                        <br />
                        <span class="badge affiliateSponsorDirect badge-info"></span>
                    </div>

                    <div class="table-responsive dataAffiliate">
                        <table class="table">
                            <tr>
                                <td width="10"><i class="fa fa-user"></i></td>
                                <td><?php echo $this->lang->line('ind_binario_modal_afiliado_form_nome');?></td>
                                <td><b class="affiliateName"></b></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-mobile"></i></td>
                                <td><?php echo $this->lang->line('ind_binario_modal_afiliado_form_celular');?></td>
                                <td class="affiliateMobile"></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-clock"></i></td>
                                <td><?php echo $this->lang->line('ind_binario_modal_afiliado_form_data_cadastro');?></td>
                                <td class="affiliateSignup"></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-hourglass-half"></i></td>
                                <td><?php echo $this->lang->line('ind_binario_modal_afiliado_form_ultimo_login');?></td>
                                <td>
                                    <span class="badge badge-primary affiliateLastLogin"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-users"></i></td>
                                <td><?php echo $this->lang->line('ind_binario_modal_afiliado_form_indicados_diretos');?></td>
                                <td class="affiliateDirect"></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-arrow-left"></i></td>
                                <td><?php echo $this->lang->line('ind_binario_modal_afiliado_form_indicados_lado_esquerdo');?></td>
                                <td class="affiliateLeft"></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-arrow-right"></i></td>
                                <td><?php echo $this->lang->line('ind_binario_modal_afiliado_form_indicados_lado_direito');?></td>
                                <td class="affiliateRight"></td>
                            </tr>

                            <tr>
                                <td width="10"><i class="fa fa-user"></i></td>
                                <td><?php echo $this->lang->line('ind_binario_modal_afiliado_form_plano_ativo');?></td>
                                <td><b class="affiliateActivePlan"></b></td>
                            </tr>

                            <tr>
                                <td width="10"><i class="fa fa-user"></i></td>
                                <td><?php echo $this->lang->line('ind_binario_modal_afiliado_form_plano_ativo_data');?></td>
                                <td><b class="affiliateActivePlanDate"></b></td>
                            </tr>


                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo $this->lang->line('fechar');?></button>
                <a href="javascript:void(0);" class="btn btn-success network-access-btn"><?php echo $this->lang->line('ind_binario_modal_afiliado_visualizar_rede_button');?></a>
            </div>
        </div>
    </div>
</div>