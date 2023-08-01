<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Visão Geral - <?php echo $nome_pagina;?></h4>
                <p class="card-title-desc">Encontre abaixo uma tabela com a <?php echo $nome_pagina;?></p>

                <div>
                
                    <?php if($this->session->flashdata('pacotes_message')) echo $this->session->flashdata('pacotes_message'); ?>

                    <div class="table-responsive">
                        <a href="<?php echo base_url($rotas->admin_pacotes_novo);?>" class="btn btn-success mb-4"><i class="fa fa-plus"></i> Novo Pacote</a>
                        <?php
                        if($pacotes !== false){
                        ?>
                        <table id="" class="table table-striped simpletable_order_by_0_desc">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Plano</th>
                                <th>Valor</th>
                                <th>Níveis Ind.</th>
                                <th>Dias pagantes</th>
                                <th>Porcentagem</th>
                                <th>Compras Simult.</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($pacotes as $pacote){

                                $rotaPacotesEditar = str_replace(array('(:num)', '(:any)'), array($pacote->id, $pacote->id), $rotas->admin_pacotes_editar);
                                $rotaPacotesExcluir = str_replace(array('(:num)', '(:any)'), array($pacote->id, $pacote->id), $rotas->admin_pacotes_excluir);
                                
                            ?>
                            <tr>
                                <th><?php echo $pacote->id;?></th>
                                <td><?php echo $pacote->nome;?></td>
                                <td><?php echo MOEDA;?> <?php echo number_format($pacote->valor, 2, ',', '.');?></td>
                                <td>
                                    <?php
                                    $niveis_indicacao = json_decode($pacote->niveis_indicacao, true);
                                    echo count($niveis_indicacao);
                                    ?>
                                     níveis
                                </td>
                                <td><?php echo $pacote->quantidade_dias;?> dias</td>
                                <td><?php echo $pacote->percentual_pago;?>%</td>
                                <td><?php echo $pacote->compras_simultaneas;?></td>
                                <td>
                                <?php
                                if($pacote->exibir == 0){
                                    $text = 'Inativo';
                                    $color = 'danger';
                                }else{
                                    $text = 'Ativo';
                                    $color = 'success';
                                }
                                ?>
                                <span class="badge badge-<?php echo $color;?>"><?php echo $text;?></span>
                                </td>
                                <td>
                                    <a href="<?php echo base_url($rotaPacotesEditar);?>" class="btn btn-info">Editar</a>
                                    <a href="<?php echo base_url($rotaPacotesExcluir);?>" class="btn btn-danger">Excluir</a>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                        }else{
                            echo alerts('Não há nenhum plano cadastrado no sistema.', 'info');
                        }
                        ?>
                    </div>

                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->