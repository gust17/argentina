<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title"><?php echo $nome_pagina;?></h4>

                <div>

                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#rendimento" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-user"></i></span>
                                <span class="d-none d-sm-block">Rendimento</span> 
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#rede" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-users"></i></span>
                                <span class="d-none d-sm-block">Rede</span> 
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane active" id="rendimento" role="tabpanel">
                            <div class="table-responsive">
                                <?php
                                if($listaPrevisaoRendimento !== false){
                                ?>
                                <table id="" class="table table-striped simpletable">
                                    <thead>
                                    <tr>
                                        <th>Data de liberação</th>
                                        <th>Raiz disponível</th>
                                        <th>Lucro disponível</th>
                                        <th>Total a Liberar</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach($listaPrevisaoRendimento as $previsaoRendimento){

                                        $dataLiberacao = LiberacaoDiasUteis($previsaoRendimento->data, 15);
                                        
                                    ?>
                                    <tr <?php echo ($dataLiberacao == date('Y-m-d')) ? 'style="background-color:green;color:#fff;" class="hoje"' : '';?>">
                                        <th><?php echo $dataLiberacao;?></th>
                                        <td><?php echo MOEDA.' '.number_format($previsaoRendimento->totalInvestido, 2, ',', '.');?></td>
                                        <td><?php echo MOEDA.' '.number_format(($previsaoRendimento->totalInvestido * (50/100)), 2, ',', '.');?></td>
                                        <td><?php echo MOEDA.' '.number_format($previsaoRendimento->totalInvestido + ($previsaoRendimento->totalInvestido * (50/100)), 2, ',', '.');?></td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <?php
                                }else{
                                    echo alerts('Nenhuma previsão até o momento', 'info');
                                }
                                ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="rede" role="tabpanel">
                            <div class="table-responsive">
                                <table id="" class="table table-striped simpletable_order_by_0_asc">
                                    <thead>
                                    <tr>
                                        <th>Data de liberação</th>
                                        <th>Total Liberado</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr style="background-color:green;color:#fff" class="hoje">
                                        <th><?php echo date('Y-m-d');?> (Hoje)</th>
                                        <td><?php echo MOEDA.' '.number_format($previsaoRede, 2, ',', '.');?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->