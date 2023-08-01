<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Editar um pacote</h4>
                <p class="card-title-desc">Faça a edição de um pacote cadastrado no sistema.</p>

                <div class="mt-4">
                    <div class="table-responsive">
                        
                        <?php if(isset($message)) echo $message;?>

                        <?php
                        if($pacote !== false){
                        ?>
                        
                        <form action="" method="post">
                            <table id="" class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>Nome *</td>
                                        <td><input type="text" name="nome" class="form-control" placeholder="Nome do pacote" value="<?php echo $pacote->nome;?>" required /></td>
                                    </tr>
                                    <tr>
                                        <td>Valor *</td>
                                        <td><input type="text" name="valor" class="form-control" placeholder="Valor do pacote" data-plugin="moneymask" value="<?php echo $pacote->valor;?>" required /></td>
                                    </tr>
                                    <tr>
                                        <td>Níveis de indicação</td>
                                        <td>
                                            <?php
                                            $niveisIndicacao = json_decode($pacote->niveis_indicacao, true);
                                            if(!empty($niveisIndicacao)){
                                                
                                                $last = 0;

                                                foreach($niveisIndicacao as $nivel=>$nivelPorcentagem){
                                            ?>
                                            <input type="text" name="niveis[<?php echo $nivel;?>]" class="form-control mb-2" data-nivel="<?php echo $nivel;?>" value="<?php echo $nivelPorcentagem;?>" data-plugin="moneymask" placeholder="Porcentagem do nível <?php echo $nivel;?>" />
                                            <?php
                                                $last = $nivel;
                                            }
                                            $next = $last+1;
                                            }else{
                                                $last = 0;
                                                $next = 1;
                                            }
                                            ?>
                                            <input type="text" name="niveis[<?php echo $last+1;?>]" class="form-control mb-2" data-nivel="<?php echo $last+1;?>" data-plugin="moneymask" placeholder="Porcentagem do nível <?php echo $last+1;?>" />

                                            <a href="javascript:void(0);" class="btn btn-info addNivel" data-next-nivel="<?php echo $next+1;?>"><i class="fa fa-plus"></i> Adicionar Nível</a>
                                            <a href="javascript:void(0);" class="btn btn-danger deleteNivel" data-last-nivel="<?php echo $last+1;?>"><i class="fa fa-times"></i> Excluir Último Nível</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pontos de Carreira</td>
                                        <td><input type="number" name="pontos" class="form-control" placeholder="Pontos para o plano de carreira" value="<?php echo $pacote->pontos;?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Regra de rendimento* </td>
                                        <td>
                                            <select name="dia_util" class="form-control" required>
                                                <option value="1" <?php echo ($pacote->dia_util == 1) ? 'selected' : '';?>>Rende só em dia útil</option>
                                                <option value="0" <?php echo ($pacote->dia_util == 0) ? 'selected' : '';?>>Rende também em finais de semana</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Dias de Rendimento *</td>
                                        <td><input type="number" name="dias" class="form-control" placeholder="Quantos dias o pacote irá render" value="<?php echo $pacote->quantidade_dias;?>" required /></td>
                                    </tr>
                                    <tr>
                                        <td>Percentual a render *</td>
                                        <td><input type="text" name="percentual" class="form-control" placeholder="Percentual que o pacote irá render" data-plugin="moneymask" value="<?php echo $pacote->percentual_pago;?>" required /></td>
                                    </tr>
                                    <tr>
                                        <td>Score necessário para compra</td>
                                        <td><input type="number" name="score_necessario" class="form-control" placeholder="Score preciso para comprar o plano" value="<?php echo $pacote->score_necessario;?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Score que o plano vai gerar</td>
                                        <td><input type="number" name="score_ganho" class="form-control" placeholder="Score que o afiliado vai ganhar" value="<?php echo $pacote->score_ganho;?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Comprar Simultâneas *</td>
                                        <td><input type="number" name="compras" class="form-control" placeholder="Compras simultâneas desse pacote" value="<?php echo $pacote->compras_simultaneas;?>" required /></td>
                                    </tr>
                                    <tr>
                                        <td>Habilitar Pacote *</td>
                                        <td>
                                            <select name="exibir" class="form-control" required>

                                                <option value="1" <?php echo ($pacote->exibir == 1) ? 'selected' : '';?>>Sim</option>
                                                <option value="0" <?php echo ($pacote->exibir == 0) ? 'selected' : '';?>>>Não</option>
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
                        <?php
                        }else{
                            echo alerts('Pacote não cadastrado no sistema.', 'danger');
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->