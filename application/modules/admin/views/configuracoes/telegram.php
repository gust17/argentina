<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Editar Telegram</h4>
                <p class="card-title-desc">Editar dados da API do Telegram.</p>

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
                                        $habilitado = SystemInfo('habilitar_telegram');
                                        ?>
                                        <option value="1" <?php echo ($habilitado == 1) ? 'selected' : '';?>>Sim</option>
                                        <option value="0" <?php echo ($habilitado == 0) ? 'selected' : '';?>>Não</option>
                                        </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>ChatID</td>
                                        <td><input type="text" name="chatid_telegram" class="form-control" placeholder="Chat ID" value="<?php echo SystemInfo('chatid_telegram');?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Token</td>
                                        <td><input type="text" name="token" class="form-control" placeholder="Token" value="<?php echo SystemInfo('token_telegram');?>" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button type="submit" name="submit" value="Atualizar" class="btn btn-success btn-block">Atualizar API</button>
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