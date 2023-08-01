<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Editar API Asaas</h4>
                <p class="card-title-desc">Edite as configurações da API do Asaas.</p>

                <div class="mt-4">
                    <div class="table-responsive">
                        
                        <?php if(isset($message)) echo $message;?>
                        
                        <form action="" method="post">
                            <table id="" class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>Habilitar API?</td>
                                        <td>
                                        <select name="asaas_habilitado" class="form-control">
                                        <?php
                                        $habilitado = SystemInfo('asaas_habilitado');
                                        ?>
                                        <option value="1" <?php echo ($habilitado == 1) ? 'selected' : '';?>>Sim</option>
                                        <option value="0" <?php echo ($habilitado == 0) ? 'selected' : '';?>>Não</option>
                                        </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Dias para Vencimento do Boleto</td>
                                        <td><input type="number" name="asaas_vencimento" class="form-control" placeholder="Dias para vencimento" value="<?php echo SystemInfo('asaas_vencimento');?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Token</td>
                                        <td><input type="text" name="asaas_token" class="form-control" placeholder="Token" value="<?php echo SystemInfo('asaas_token');?>" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button type="submit" name="submit" value="Atualizar" class="btn btn-success btn-block">Atualizar API Asaas</button>
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