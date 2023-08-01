<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Visão Geral - <?php echo $nome_pagina;?></h4>
                <p class="card-title-desc">Encontre abaixo uma tabela com a <?php echo $nome_pagina;?></p>

                <div>
                
                    <?php if($this->session->flashdata('contas_message')) echo $this->session->flashdata('contas_message'); ?>

                    <div class="table-responsive">

                        <a href="<?php echo base_url($rotas->admin_contas_nova);?>" class="btn btn-success mb-4"><i class="fa fa-plus"></i> Novo Conta Bancária</a>

                        <?php
                        if($contas !== false){
                        ?>
                        <table id="" class="table table-striped simpletable_order_by_0_desc">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Banco</th>
                                <th>AG</th>
                                <th>Conta</th>
                                <th>Tipo</th>
                                <th>Titular</th>
                                <th>Documento</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($contas as $conta){
;
                                $rotaContaEditar = str_replace(array('(:num)', '(:any)'), array($conta->id, $conta->id), $rotas->admin_contas_editar);
                                $rotaContaExcluir = str_replace(array('(:num)', '(:any)'), array($conta->id, $conta->id), $rotas->admin_contas_excluir);
                                
                            ?>
                            <tr>
                                <th><?php echo $conta->id;?></th>
                                <td><?php echo BancoID($conta->banco);?></td>
                                <td><?php echo $conta->agencia;?></td>
                                <td><?php echo $conta->conta;?></td>
                                <td><?php echo ($conta->conta_tipo == 1) ? 'Conta Corrente' : 'Conta Poupança';?></td>
                                <td><?php echo $conta->titular;?></td>
                                <td><?php echo $conta->documento;?></td>
                                <td>
                                    <a href="<?php echo base_url($rotaContaEditar);?>" class="btn btn-info">Editar</a>
                                    <a href="<?php echo base_url($rotaContaExcluir);?>" class="btn btn-danger">Excluir</a>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                        }else{
                            echo alerts('Não há nenhuma conta bancária cadastrada até o momento.', 'info');
                        }
                        ?>
                    </div>

                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->