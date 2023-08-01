<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Editar CoinPayments</h4>
                <p class="card-title-desc">Editar dados da API Coinpayments para cripto-moedas.</p>

                <div class="mt-4">
                    <div class="table-responsive">
                        
                        <?php if(isset($message)) echo $message;?>
                        
                        <form action="" method="post">
                            <table id="" class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>Habilitar</td>
                                        <td>
                                        <select name="habilitar" class="form-control">
                                        <?php
                                        $habilitado = SystemInfo('coinpayments_habilitar');
                                        ?>
                                        <option value="1" <?php echo ($habilitado == 1) ? 'selected' : '';?>>Sim</option>
                                        <option value="0" <?php echo ($habilitado == 0) ? 'selected' : '';?>>Não</option>
                                        </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Public Key</td>
                                        <td><input type="text" name="public_key" class="form-control" placeholder="PublicKey da API" value="<?php echo SystemInfo('coinpayments_public_key');?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Private Key</td>
                                        <td><input type="text" name="private_key" class="form-control" placeholder="PrivateKey da API" value="<?php echo SystemInfo('coinpayments_private_key');?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Merchant Code</td>
                                        <td><input type="text" name="merchant" class="form-control" placeholder="Código Merchant" value="<?php echo SystemInfo('coinpayments_merchant');?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Cryptos aceitas</td>
                                        <td>
                                        <select class="coinpayments_criptos form-control" name="cryptos[]" multiple="multiple">
                                            <?php
                                            foreach(CryptosCoinpayments() as $crypto=>$nameCrypto){

                                                $selected = (array_key_exists($crypto, $cryptosDB)) ? 'selected' : '';
                                            ?>
                                            <option value="<?php echo $crypto;?>" <?php echo $selected;?>><?php echo $nameCrypto;?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button type="submit" name="submit" value="Atualizar" class="btn btn-success btn-block">Atualizar dados CoinPayments</button>
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->