<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Visão Geral - <?php echo $nome_pagina;?></h4>
                <p class="card-title-desc">Encontre abaixo uma tabela com a <?php echo $nome_pagina;?></p>

                <div>
                
                    <?php if($this->session->flashdata('saques_message')) echo $this->session->flashdata('saques_message'); ?>

                    <div class="table-responsive">
                        <?php
                        if($saques !== false){
                        ?>
                        <table id="" class="table table-striped simpletable_order_by_0_desc">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Login</th>
                                <th>Valor a Receber</th>
                                <th>Meio</th>
                                <th>Tipo de Saque</th>
                                <th>Status</th>
                                <th>Solicitado em</th>
                                <th>Limite para pagamento</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($saques as $saque){

                                $rotaSaqueVisualizar = str_replace(array('(:num)', '(:any)'), array($saque->id, $saque->id), $rotas->admin_saques_visualizar);
                                $rotaSaqueBaixa = str_replace(array('(:num)', '(:any)'), array($saque->id, $saque->id), $rotas->admin_saques_baixa);
                                $rotaSaqueEstorno= str_replace(array('(:num)', '(:any)'), array($saque->id, $saque->id), $rotas->admin_saques_estornar);
                                $rotaSaqueExcluir = str_replace(array('(:num)', '(:any)'), array($saque->id, $saque->id), $rotas->admin_saques_excluir);
                                
                            ?>
                            <tr>
                                <th><?php echo $saque->id;?></th>
                                <td><?php echo $saque->login;?></td>
                                <td><?php echo MOEDA;?> <?php echo number_format($saque->valor_receber, 2, ',', '.');?></td>
                                <td><?php echo MeioRecebimento($saque->meio_recebimento);?></td>
                                <td><?php echo CategoriaExtrato($saque->tipo_saque);?></td>
                                <td>
                                <?php
                                if($saque->status == 0){
                                    $text = 'Pendente';
                                    $color = 'warning';
                                }elseif($saque->status == 1){
                                    $text = 'Pago';
                                    $color = 'success';
                                }else{
                                    $text = 'Estornado';
                                    $color = 'danger';
                                }
                                ?>
                                <span class="badge badge-<?php echo $color;?>"><?php echo $text;?></span>
                                </td>
                                <td><?php echo date('d/m/Y H:i:s', strtotime($saque->data_solicitacao));?></td>
                                <td>
                                <?php
                                if($saque->urgente == 0){
                                    $dataDiasUteis = DiasUteis($saque->data_solicitacao, $dias_pagamento_saque);
                                    $horarioSolicitacao = date('H:i:s', strtotime($saque->data_solicitacao));

                                    echo date('d/m/Y', strtotime($dataDiasUteis)).' '.$horarioSolicitacao;
                                }else{

                                    echo date('d/m/Y H:i:s', strtotime($saque->data_solicitacao_urgencia) + (60*60*SystemInfo('prazo_saque_urgencia')));
                                }
                                ?>
                                </td>
                                <td>
                                    <?php
                                    if($permitidoVisualizar){
                                    ?>
                                    <a href="<?php echo base_url($rotaSaqueVisualizar);?>" class="btn btn-success">Visualizar</a>
                                    <?php
                                    }
                                    ?>

                                    <?php
                                    if($saque->status == 0 && EnabledMasterKey()){
                                    ?>

                                    <?php
                                    if($permitidoBaixa){
                                    ?>
                                    <a href="<?php echo base_url($rotaSaqueBaixa);?>" class="btn btn-info">Dar Baixa</a>
                                    <?php
                                    }
                                    ?>

                                    <?php
                                    if($permitidoEstornar){
                                    ?>
                                    <a href="<?php echo base_url($rotaSaqueEstorno);?>" class="btn btn-warning estornarSaque">Estornar</a>
                                    <?php
                                    }
                                    ?>
                                    
                                    <?php
                                    }

                                    if(EnabledMasterKey()){
                                    ?>
                                    <?php
                                    if($permitidoExcluir){
                                    ?>
                                    <a href="<?php echo base_url($rotaSaqueExcluir);?>" class="btn btn-danger">Excluir</a>
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
                            echo alerts('Não há nenhum saque solicitado até o momento.', 'info');
                        }
                        ?>
                    </div>

                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->