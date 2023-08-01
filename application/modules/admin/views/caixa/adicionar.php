<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Adicionar novo registro</h4>
                <p class="card-title-desc">Adicione um novo registro ao caixa da empresa. Lembramos que ao adicionar, não será mais possível editar ou excluir por segurança.</p>

                <div class="mt-4">
                    <div class="table-responsive">

                        <?php if (isset($message)) echo $message; ?>

                        <form action="" method="post" class="formAddCaixa">
                            <table id="" class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>Detalhes do Registro</td>
                                        <td>
                                            <textarea class="form-control" name="descricao" placeholder="Informe uma descrição do registro para exibir na lista do caixa" required></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Valor</td>
                                        <td><input type="text" name="valor" class="form-control" placeholder="Valor" data-plugin="moneymask" required /></td>
                                    </tr>
                                    <tr>
                                        <td>Tipo</td>
                                        <td>
                                            <select name="tipo" class="form-control" required>
                                                <option value="1">Entrada</option>
                                                <option value="2">Saída</option>
                                                <option value="3">Custos da Empresa</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <a href="javascript:void(0)" class="btn btn-success btn-block addRegistro">Adicionar Registro</a>
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
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