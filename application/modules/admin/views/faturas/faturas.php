<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Visão Geral - <?php echo $nome_pagina;?></h4>
                <p class="card-title-desc">Encontre abaixo uma tabela com a <?php echo $nome_pagina;?></p>

                <div>
                
                    <?php if($this->session->flashdata('faturas_message')) echo $this->session->flashdata('faturas_message'); ?>

                    <div class="table-responsive">
                        <?php
                        if($faturas !== false){
                        ?>
                        <table id="" class="table table-striped simpletable_order_by_0_desc">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Login</th>
                                <th>Plano</th>
                                <th>Valor</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($faturas as $fatura){

                                $rotaFaturaAtivar = str_replace(array('(:num)', '(:any)'), array($fatura->id, $fatura->id), $rotas->admin_faturas_ativar);
                                $rotaFaturaAtivarCortesia = str_replace(array('(:num)', '(:any)'), array($fatura->id, $fatura->id), $rotas->admin_faturas_ativar_cortesia);
                                $rotaFaturaExcluir = str_replace(array('(:num)', '(:any)'), array($fatura->id, $fatura->id), $rotas->admin_faturas_excluir);
                                
                            ?>
                            <tr>
                                <th><?php echo $fatura->id;?></th>
                                <td><?php echo $fatura->login;?></td>
                                <td><?php echo PlanInfo($fatura->id_plano, 'nome');?></td>
                                <td><?php echo MOEDA;?> <?php echo number_format($fatura->valor, 2, ',', '.');?></td>
                                <td>
                                <?php
                                if($fatura->status == 0){
                                    $text = 'Pendente';
                                    $color = 'warning';
                                }elseif($fatura->status == 1){
                                    $text = 'Pago';
                                    $color = 'success';
                                }else{
                                    $text = 'Expirada';
                                    $color = 'danger';
                                }
                                ?>
                                <span class="badge badge-<?php echo $color;?>"><?php echo $text;?></span>
                                </td>
                                <td>
                                    <?php
                                    if(EnabledMasterKey()){
                                    ?>

                                    <?php
                                    if($fatura->status == 0){
                                    ?>

                                    <?php
                                    if($permitidoNormalmente){
                                    ?>
                                    <a href="<?php echo base_url($rotaFaturaAtivar);?>" class="btn btn-success">Ativar Normalmente</a>
                                    <?php
                                    }
                                    ?>

                                    <?php
                                    if($permitidoCortesia){
                                    ?>
                                    <a href="<?php echo base_url($rotaFaturaAtivarCortesia);?>" class="btn btn-warning">Ativar Cortesia</a>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    }
                                    ?>

                                    <?php
                                    if($permitidoExcluir){
                                    ?>
                                    <a href="<?php echo base_url($rotaFaturaExcluir);?>" class="btn btn-danger">Excluir</a>
                                    <?php
                                    }
                                    ?>
                                    
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                        }else{
                            echo alerts('Não há nenhuma fatura cadastrada.', 'info');
                        }
                        ?>
                    </div>

                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->