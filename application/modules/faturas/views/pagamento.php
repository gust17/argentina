<?php
$valida = false;

?>
    <div class="pcoded-content">
        <div class="card">
            <div class="card-header">
                <h5><?php echo $nome_pagina; ?></h5>
            </div>
            <div class="card-body table-border-style">

                <?php
                if (isset($message)) echo $message;
                ?>

                <?php
                if ($fatura !== false) {
                    ?>

                    <?php
                    if ($contas !== false) {
                        foreach ($contas as $conta) {
                            ?>
                            <a class="btn btn-dark m-t-5" data-toggle="collapse"
                               href="#banco_<?php echo $conta->banco; ?>" role="button" aria-expanded="false"
                               aria-controls="banco_<?php echo $conta->banco; ?>">
                                <?php echo BancoID($conta->banco); ?>
                            </a>
                            <?php
                        }
                    }
                    ?>

                    <?php
                    if ($pixHabilitado == 1) {
                        ?>
                        <a class="btn btn-dark m-t-5" data-toggle="collapse" href="#pix" role="button"
                           aria-expanded="false" aria-controls="pix">
                            <?php echo $this->lang->line('fat_pagamento_pix'); ?>
                        </a>
                        <?php
                    }
                    ?>

                    <?php
                    if (!empty($cryptosDB) && $coinpaymentsHabilitado == 1) {
                        foreach ($cryptosDB as $cryptoValue => $cryptoName) {
                            ?>
                            <a class="btn btn-dark m-t-5" data-toggle="collapse" href="#<?php echo $cryptoValue; ?>"
                               role="button" aria-expanded="false" aria-controls="<?php echo $cryptoName ?>">
                                <?php echo $cryptoName ?>
                            </a>
                            <?php
                        }
                    }
                    ?>

                    <?php
                    if ($asaasHabilitado == 1) {
                        ?>
                        <a class="btn btn-dark m-t-5" data-toggle="collapse" href="#boleto" role="button"
                           aria-expanded="false" aria-controls="Boleto">
                            <?php echo $this->lang->line('fat_pagamento_boleto'); ?>
                        </a>
                        <?php
                    }
                    ?>

                    <a class="btn btn-dark m-t-5" data-toggle="collapse" href="#bpc" role="button" aria-expanded="false"
                       aria-controls="BCP">
                        USDT
                    </a>
                    <?php
                    if ($valida) {
                        ?>

                        <a class="btn btn-dark m-t-5" data-toggle="collapse" href="#bbva" role="button"
                           aria-expanded="false" aria-controls="bbva">
                            Banco BBVA (Argentina)
                        </a>

                        <?php
                    }

                    ?>


                    <div class="collapse" id="bbva">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data" id="bbva">


                                <div class="table-responsive dt-responsive">
                                    Cuit: 30717574660 <br/>
                                    Razon Social: Impormed Salud S.R.L <br/>
                                    CBU: 0170001520000002164847<br/>
                                    Cuenta: CC $ 001-021648/4<br/>
                                </div>

                                <br/>

                                <h3 class="text-center"><?php echo $this->lang->line('fat_pagamento_enviar_comprovante'); ?></h3>

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i
                                                        data-feather="file"></i></span></div>
                                        <input type="file" name="comprovante" class="form-control" required/>
                                    </div>
                                </div>

                                <button type="submit" name="EnviarComprovante" load-button="on"
                                        load-text="<?php echo $this->lang->line('fat_enviando_comprovante_aguarde'); ?>"
                                        value="EnviarComprovante"
                                        class="btn btn-secondary btn-block"><?php echo $this->lang->line('fat_pagamento_enviar_comprovante_button'); ?></button>
                                <input type="hidden" name="<?php echo $csrf_name; ?>"
                                       value="<?php echo $csrf_hash; ?>"/>
                                <input type="hidden" name="banco" value="bbva"/>
                            </form>
                        </div>
                    </div>

                    <div class="collapse" id="bpc">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data" id="bcp">


                                <div class="table-responsive dt-responsive">
                                    <center>
                                        <img width="250px" src="<?php echo base_url(); ?>assets/qrcode.png" alt="">
                                        <br>
                                        <input class="form-control" type="text" id="valorInput" value="TSBUDgrDJgcPhM4zQttfUk3frzwmkoNb6X" readonly>
                                        <button  class="btn btn-secondary" onclick="copiarValor()">Copiar Valor</button>
                                        <script>
                                            function copiarValor() {
                                                // Selecionar o campo de entrada
                                                var campoInput = document.getElementById("valorInput");

                                                // Selecionar o texto dentro do campo de entrada
                                                campoInput.select();
                                                campoInput.setSelectionRange(0, 99999); // Para dispositivos móveis

                                                // Copiar o texto para a área de transferência
                                                document.execCommand("copy");

                                                // Alerta para notificar o usuário que o valor foi copiado
                                                //alert("Valor copiado: " + campoInput.value);
                                            }
                                        </script>

                                    </center>
                                </div>

                                <br/>

                                <h3 class="text-center"><?php echo $this->lang->line('fat_pagamento_enviar_comprovante'); ?></h3>

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i
                                                        data-feather="file"></i></span></div>
                                        <input type="file" name="comprovante" class="form-control" required/>
                                    </div>
                                </div>

                                <button type="submit" name="EnviarComprovante" load-button="on"
                                        load-text="<?php echo $this->lang->line('fat_enviando_comprovante_aguarde'); ?>"
                                        value="EnviarComprovante"
                                        class="btn btn-secondary btn-block"><?php echo $this->lang->line('fat_pagamento_enviar_comprovante_button'); ?></button>
                                <input type="hidden" name="<?php echo $csrf_name; ?>"
                                       value="<?php echo $csrf_hash; ?>"/>
                                <input type="hidden" name="banco" value="bpc"/>
                            </form>
                        </div>
                    </div>

                    <?php
                    if ($contas !== false) {
                        foreach ($contas as $conta) {

                            $valorPagar = addCentavos($fatura->valor, +$fatura->id);
                            ?>
                            <div class="collapse" id="banco_<?php echo $conta->banco; ?>">
                                <div class="card-body">
                                    <form action="" method="post" enctype="multipart/form-data"
                                          id="pay_<?php echo $conta->banco; ?>">

                                        <h2><?php echo sprintf($this->lang->line('fat_pagamento_via_conta_bancaria'), BancoID($conta->banco)); ?></h2>

                                        <?php echo sprintf($this->lang->line('fat_pagamento_via_conta_bancaria_desc_1'), BancoID($conta->banco)); ?>
                                        <?php echo sprintf($this->lang->line('fat_pagamento_via_conta_bancaria_desc_2'), MOEDA . ' ' . number_format($valorPagar, 2, ',', '.')); ?>
                                        <?php echo $this->lang->line('fat_pagamento_via_conta_bancaria_desc_3'); ?>

                                        <div class="table-responsive dt-responsive">
                                            <table class="table table-striped table-bordered">
                                                <tr>
                                                    <td class="bg-success text-white"><?php echo $this->lang->line('fat_pagamento_via_conta_bancaria_banco'); ?></td>
                                                    <td class="bg-success text-white"><?php echo BancoID($conta->banco); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="bg-success text-white"><?php echo $this->lang->line('fat_pagamento_via_conta_bancaria_agencia'); ?></td>
                                                    <td class="bg-success text-white"><?php echo $conta->agencia; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="bg-success text-white"><?php echo $this->lang->line('fat_pagamento_via_conta_bancaria_conta'); ?></td>
                                                    <td class="bg-success text-white"><?php echo $conta->conta; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="bg-success text-white"><?php echo $this->lang->line('fat_pagamento_via_conta_bancaria_tipo'); ?></td>
                                                    <td class="bg-success text-white"><?php echo ($conta->conta_tipo == 1) ? $this->lang->line('fat_pagamento_via_conta_bancaria_corrente') : $this->lang->line('fat_pagamento_via_conta_bancaria_poupanca'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="bg-success text-white"><?php echo $this->lang->line('fat_pagamento_via_conta_bancaria_titular'); ?></td>
                                                    <td class="bg-success text-white"><?php echo $conta->titular; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="bg-success text-white"><?php echo $this->lang->line('fat_pagamento_via_conta_bancaria_documento'); ?></td>
                                                    <td class="bg-success text-white"><?php echo $conta->documento; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="bg-success text-white"><?php echo $this->lang->line('fat_pagamento_via_conta_bancaria_valor_depositar'); ?></td>
                                                    <td class="bg-success text-white"><?php echo MOEDA; ?><?php echo number_format($valorPagar, 2, ',', '.'); ?></td>
                                                </tr>
                                                </tr>
                                            </table>
                                            <?php echo $this->lang->line('fat_pagamento_via_conta_bancaria_obs'); ?>
                                        </div>

                                        <br/>

                                        <h3 class="text-center"><?php echo $this->lang->line('fat_pagamento_enviar_comprovante'); ?></h3>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <!-- <div class="input-group-prepend"><span class="input-group-text"><i data-feather="file"></i></span></div> -->
                                                <input type="file" name="comprovante" class="form-control" required/>
                                            </div>
                                        </div>

                                        <button type="submit" name="EnviarComprovante" load-button="on"
                                                load-text="<?php echo $this->lang->line('fat_enviando_comprovante_aguarde'); ?>"
                                                value="<?php echo BancoID($conta->banco); ?>"
                                                class="btn btn-secondary btn-block"><?php echo $this->lang->line('fat_pagamento_enviar_comprovante_button'); ?></button>
                                        <input type="hidden" name="<?php echo $csrf_name; ?>"
                                               value="<?php echo $csrf_hash; ?>"/>
                                        <input type="hidden" name="banco" value="<?php echo $conta->banco; ?>"/>
                                    </form>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>

                    <!-- payment via cryptocurrency -->
                    <?php
                    if (!empty($cryptosDB) && $coinpaymentsHabilitado == 1) {
                        foreach ($cryptosDB as $cryptoValue => $cryptoName) {
                            ?>
                            <div class="collapse" id="<?php echo $cryptoValue; ?>">
                                <div class="card-body">

                                    <div class="instrucoes_crypto" data-crypto="<?php echo $cryptoValue; ?>">

                                        <h2><?php echo sprintf($this->lang->line('fat_pagamento_via_cripto'), $cryptoName); ?></h2>

                                        <?php $this->lang->line('fat_pagamento_via_cripto_desc_1'); ?>
                                        <?php echo sprintf($this->lang->line('fat_pagamento_via_cripto_desc_2'), $cryptoValue); ?>

                                        <p>
                                        <ol>
                                            <li><?php echo sprintf($this->lang->line('fat_pagamento_via_cripto_desc_li_1'), $cryptoName); ?></li>
                                            <li><?php echo sprintf($this->lang->line('fat_pagamento_via_cripto_desc_li_2'), $cryptoValue); ?></li>
                                            <li><?php echo $this->lang->line('fat_pagamento_via_cripto_desc_li_3'); ?></li>
                                            <li><?php echo $this->lang->line('fat_pagamento_via_cripto_desc_li_4'); ?></li>
                                        </ol>
                                        </p>
                                    </div>

                                    <div class="table-responsive pagamento_crypto"
                                         data-crypto="<?php echo $cryptoValue; ?>" style="display:none;">

                                        <h3><?php echo $this->lang->line('fat_pagamento_via_cripto_ins_titulo'); ?></h3>

                                        <table class="table table-striped table-bordered">
                                            <tr>
                                                <td class="bg-success text-white"><?php echo $this->lang->line('fat_pagamento_via_cripto_carteira'); ?></td>
                                                <td class="crypto_carteira"></td>
                                            </tr>
                                            <tr>
                                                <td class="bg-success text-white"><?php echo $this->lang->line('fat_pagamento_via_cripto_valor_exato'); ?></td>
                                                <td class="crypto_fracao"></td>
                                            </tr>
                                            <tr>
                                                <td class="bg-success text-white"><?php echo $this->lang->line('fat_pagamento_via_cripto_via_qrcode'); ?></td>
                                                <td class="bg-success text-white">
                                                    <img class="img-thumbnail img-fluid crypto_qrcode"
                                                         style="width:200px;"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><?php echo sprintf($this->lang->line('fat_pagamento_via_cripto_desc_obs'), $cryptoValue); ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <button type="button" name="viaCrypto" value="GerarCarteira"
                                            data-crypto="<?php echo $cryptoValue; ?>"
                                            class="btn btn-secondary text-uppercase btn-block gerarCarteira"><i
                                                data-feather="refresh-cw"></i>&nbsp; <?php echo $this->lang->line('fat_pagamento_via_cripto_gerar_button'); ?>
                                    </button>
                                    <input type="hidden" name="id_plano" value="<?php echo $fatura->id; ?>"/>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>

                    <?php
                    if ($asaasHabilitado == 1) {
                        ?>

                        <!-- payment via boleto -->
                        <div class="collapse" id="boleto">
                            <div class="card-body">

                                <?php
                                echo alerts('Meio indisponible', 'danger');
                                ?>
                                <!-- <form action="" method="post">
                                <h2><?php echo $this->lang->line('fat_pagamento_via_boleto'); ?></h2>

                                <?php echo $this->lang->line('fat_pagamento_via_boleto_desc_1'); ?>
                                <?php echo $this->lang->line('fat_pagamento_via_boleto_desc_2'); ?>
                                <?php echo $this->lang->line('fat_pagamento_via_boleto_desc_3'); ?>


                                <button type="submit" name="GerarBoletoAsaas" value="Gerar" class="btn btn-secondary btn-block"><i class="fa fa-print"></i> <?php echo $this->lang->line('fat_pagamento_via_boleto_gerar_button'); ?></button>
                                <input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_hash; ?>" />
                            </form> -->
                            </div>
                        </div>

                        <?php
                    }
                    ?>

                    <?php
                    if ($pixHabilitado == 1) {
                        ?>
                        <!-- payment via pix -->
                        <div class="collapse" id="pix">
                            <div class="card-body">
                                <form action="" method="post" enctype="multipart/form-data" id="bcp">


                                    <div class="table-responsive dt-responsive">
                                        Chave: <?php echo SystemInfo('chave_pix'); ?>
                                    </div>

                                    <br/>

                                    <h3 class="text-center"><?php echo $this->lang->line('fat_pagamento_enviar_comprovante'); ?></h3>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i
                                                            data-feather="file"></i></span></div>
                                            <input type="file" name="comprovante" class="form-control" required/>
                                        </div>
                                    </div>

                                    <button type="submit" name="EnviarComprovante" load-button="on"
                                            load-text="<?php echo $this->lang->line('fat_enviando_comprovante_aguarde'); ?>"
                                            value="EnviarComprovante"
                                            class="btn btn-secondary btn-block"><?php echo $this->lang->line('fat_pagamento_enviar_comprovante_button'); ?></button>
                                    <input type="hidden" name="<?php echo $csrf_name; ?>"
                                           value="<?php echo $csrf_hash; ?>"/>
                                    <input type="hidden" name="banco" value="pix"/>
                                </form>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                } else {
                    echo alerts($this->lang->line('fat_pagamento_error_visualizar_fatura'), 'danger');
                }
                ?>
            </div>
        </div>
    </div>
<?php echo $this->recaptcha->getScriptTag(); ?>
<?php
echo $this->recaptcha->getWidget('pay_pix');
echo $this->recaptcha->getWidget('pay_bankon');
if ($contas !== false) {
    foreach ($contas as $conta) {
        echo $this->recaptcha->getWidget('pay_' . $conta->banco);
    }
}
?>