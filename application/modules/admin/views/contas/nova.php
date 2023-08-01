<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Cadastrar nova conta bancária</h4>
                <p class="card-title-desc">Adicione uma conta bancária no sistema.</p>

                <div class="mt-4">
                    <div class="table-responsive">
                        
                        <?php if(isset($message)) echo $message;?>
                        
                        <form action="" method="post">
                            <table id="" class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>Banco *</td>
                                        <td>
                                            <select name="banco" class="form-control" required>
                                            <?php
                                            foreach(ListaBancos() as $codigo=>$banco){
                                                echo '<option value="'.$codigo.'">'.$codigo.' - '.$banco.'</option>';
                                            }
                                            ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Agência *</td>
                                        <td><input type="text" name="agencia" class="form-control" placeholder="Agência da conta" required /></td>
                                    </tr>
                                    <tr>
                                        <td>Conta *</td>
                                        <td><input type="text" name="conta" class="form-control" placeholder="Número da conta" required /></td>
                                    </tr>
                                    <tr>
                                        <td>Tipo de Conta * </td>
                                        <td>
                                            <select name="conta_tipo" class="form-control" required>
                                                <option value="1">Conta Corrente</option>
                                                <option value="2">Conta Poupança</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Titular *</td>
                                        <td><input type="text" name="titular" class="form-control" placeholder="Nome do titular da conta" required /></td>
                                    </tr>
                                    <tr>
                                        <td>Documento *</td>
                                        <td><input type="text" name="documento" class="form-control" placeholder="Documento do titular da conta" required /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button type="submit" name="submit" value="Adicionar Conta" class="btn btn-success btn-block">Cadastrar conta bancária</button>
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