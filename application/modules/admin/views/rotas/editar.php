<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Editar Rota</h4>
                <p class="card-title-desc">Faça a edição de uma rota, mas se atente a algumas instruções importantes para uso. Veja abaixo:</p>
                <p class="alert alert-secondary">Em rotas que conter <b>(:num)</b> ou <b>(:any)</b> lembre-se de manter essa palavra. Caso você retire, isso implicará em <b>erros gravissimos no sistema</b>, por isso mantenha atenção na edição das rotas.</p>

                <div class="mt-4">
                    <div class="table-responsive">
                        
                        <?php if(isset($message)) echo $message;?>
                        
                        <form action="" method="post">
                            <table id="" class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>Nome *</td>
                                        <td><input type="text" name="nome" class="form-control" placeholder="Descrição da rota" value="<?php echo $route->link_nome;?>" required /></td>
                                    </tr>
                                    <tr>
                                        <td>Rota *</td>
                                        <td><input type="text" name="rota" class="form-control" placeholder="URL da Rota" value="<?php echo $route->route;?>" required /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button type="submit" name="submit" value="Editar Rota" class="btn btn-success btn-block">Atualizar Rota</button>
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