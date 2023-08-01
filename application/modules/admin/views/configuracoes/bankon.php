<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Editar BankOn</h4>
                <p class="card-title-desc">Editar dados da API BankOn.</p>

                <div class="mt-4">
                    <div class="table-responsive">
                        
                        <?php if(isset($message)) echo $message;?>
                        
                        <form action="" method="post">
                            <table id="" class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>Habilitar BankOn</td>
                                        <td>
                                        <select name="habilitar_bankon" class="form-control">
                                        <?php
                                        $habilitado = SystemInfo('habilitar_bankon');
                                        ?>
                                        <option value="1" <?php echo ($habilitado == 1) ? 'selected' : '';?>>Sim</option>
                                        <option value="0" <?php echo ($habilitado == 0) ? 'selected' : '';?>>Não</option>
                                        </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>BankOn</td>
                                        <td><input type="text" name="bankon" class="form-control" placeholder="Usuário BankOn" value="<?php echo SystemInfo('conta_bankon');?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Token Consulta</td>
                                        <td><input type="text" name="token_consulta" class="form-control" placeholder="Token de Consulta BankOn" value="<?php echo SystemInfo('token_bankon_consulta');?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Token Transferência</td>
                                        <td><input type="text" name="token_transferencia" class="form-control" placeholder="Token de Transferência BankOn" value="<?php echo SystemInfo('token_bankon_transferencia');?>" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button type="submit" name="submit" value="Atualizar" class="btn btn-success btn-block">Atualizar dados BankOn</button>
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