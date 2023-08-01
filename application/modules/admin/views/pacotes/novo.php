<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Adicionar novo pacote</h4>
                <p class="card-title-desc">Crie pacotes no sistema para os afiliados aderirem.</p>

                <div class="mt-4">
                    <div class="table-responsive">
                        
                        <?php if(isset($message)) echo $message;?>
                        
                        <form action="" method="post">
                            <table id="" class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>Nome *</td>
                                        <td><input type="text" name="nome" class="form-control" placeholder="Nome do pacote" required /></td>
                                    </tr>
                                    <tr>
                                        <td>Valor *</td>
                                        <td><input type="text" name="valor" class="form-control" placeholder="Valor do pacote" data-plugin="moneymask" required /></td>
                                    </tr>
                                    <tr>
                                        <td>Níveis de indicação</td>
                                        <td>
                                            <input type="text" name="niveis[1]" class="form-control mb-2" data-nivel="1" data-plugin="moneymask" placeholder="Porcentagem do nível 1" />
                                            <input type="text" name="niveis[2]" class="form-control mb-2" data-nivel="2" data-plugin="moneymask" placeholder="Porcentagem do nível 2" />

                                            <a href="javascript:void(0);" class="btn btn-info addNivel" data-next-nivel="3"><i class="fa fa-plus"></i> Adicionar Nível</a>
                                            <a href="javascript:void(0);" class="btn btn-danger deleteNivel" data-last-nivel="2"><i class="fa fa-times"></i> Excluir Último Nível</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pontos de Carreira</td>
                                        <td><input type="number" name="pontos" class="form-control" placeholder="Pontos para o plano de carreira" /></td>
                                    </tr>
                                    <tr>
                                        <td>Regra de rendimento* </td>
                                        <td>
                                            <select name="dia_util" class="form-control" required>
                                                <option value="1">Rende só em dia útil</option>
                                                <option value="0">Rende também em finais de semana</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Dias de Rendimento *</td>
                                        <td><input type="number" name="dias" class="form-control" placeholder="Quantos dias o pacote irá render" required /></td>
                                    </tr>
                                    <tr>
                                        <td>Percentual a render *</td>
                                        <td><input type="text" name="percentual" class="form-control" placeholder="Percentual que o pacote irá render" data-plugin="moneymask" required /></td>
                                    </tr>
                                    <tr>
                                        <td>Score necessário para compra</td>
                                        <td><input type="number" name="score_necessario" class="form-control" placeholder="Score preciso para comprar o plano" /></td>
                                    </tr>
                                    <tr>
                                        <td>Score que o plano vai gerar</td>
                                        <td><input type="number" name="score_ganho" class="form-control" placeholder="Score que o afiliado vai ganhar" /></td>
                                    </tr>
                                    <tr>
                                        <td>Comprar Simultâneas *</td>
                                        <td><input type="number" name="compras" class="form-control" placeholder="Compras simultâneas desse pacote" required /></td>
                                    </tr>
                                    <tr>
                                        <td>Habilitar Pacote *</td>
                                        <td>
                                            <select name="exibir" class="form-control" required>
                                                <option value="1">Sim</option>
                                                <option value="0">Não</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button type="submit" name="submit" value="Criar Pacote" class="btn btn-success btn-block">Cadastrar novo pacote</button>
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