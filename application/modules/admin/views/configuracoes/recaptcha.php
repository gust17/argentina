<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Editar Recaptcha</h4>
                <p class="card-title-desc">Editar dados da API do Google de Recaptcha.</p>

                <div class="mt-4">
                    <div class="table-responsive">
                        
                        <?php if(isset($message)) echo $message;?>
                        
                        <form action="" method="post">
                            <table id="" class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>Site Key</td>
                                        <td><input type="text" name="site_key" class="form-control" placeholder="Site Key" value="<?php echo SystemInfo('recaptcha_site_key');?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Secret Key</td>
                                        <td><input type="text" name="secret_key" class="form-control" placeholder="Secret Key" value="<?php echo SystemInfo('recaptcha_secret_key');?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Linguagem</td>
                                        <td><input type="text" name="lang" class="form-control" placeholder="Linguagem" value="<?php echo SystemInfo('recaptcha_lang');?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Alinhamento</td>
                                        <td>
                                            <select name="align" class="form-control">
                                                <option value="center" <?php echo ($recaptcha_align == 'center') ? 'selected' : '';?>>Center</option>
                                                <option value="left" <?php echo ($recaptcha_align == 'left') ? 'selected' : '';?>>Left</option>
                                                <option value="right" <?php echo ($recaptcha_align == 'right') ? 'selected' : '';?>>Right</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button type="submit" name="submit" value="Atualizar" class="btn btn-success btn-block">Atualizar dados Recaptcha</button>
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