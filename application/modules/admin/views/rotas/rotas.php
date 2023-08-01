<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Visão Geral - <?php echo $nome_pagina;?></h4>
                <p class="card-title-desc">Encontre abaixo uma tabela com a <?php echo $nome_pagina;?></p>

                <div>
                
                    <?php if($this->session->flashdata('rotas_message')) echo $this->session->flashdata('rotas_message'); ?>

                    <div class="table-responsive">

                        <?php
                        if($routes !== false){
                        ?>
                        <table id="" class="table table-striped simpletable_order_by_0_desc">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Rota</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($routes as $route){
;
                                $rotaRotaEditar = str_replace(array('(:num)', '(:any)'), array($route->id, $route->id), $rotas->admin_configuracoes_rotas_editar);
                                
                            ?>
                            <tr>
                                <th><?php echo $route->link_nome;?></th>
                                <td><?php echo $route->route;?></td>
                                <td>
                                    <a href="<?php echo base_url($rotaRotaEditar);?>" class="btn btn-info">Editar</a>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                        }else{
                            echo alerts('Não há nenhuma rota cadastrada até o momento.', 'info');
                        }
                        ?>
                    </div>

                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->