<div class="row">
    <?php
    if($this->permission->Authorization('dashboard.entradas_totais')){
    ?>
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="float-right mt-2">
                    <i class="fa fa-dollar-sign text-success fa-3x"></i>
                </div>
                <div>
                    <h4 class="mb-1 mt-1"><?php echo MOEDA;?> <span><?php echo number_format($EntradasTotais, 2, ',', '.');?></span></h4>
                    <p class="text-muted mb-0">Entradas Totais</p>
                </div>
                </p>
            </div>
        </div>
    </div> <!-- end col-->
    <?php
    }
    ?>

    <?php
    if($this->permission->Authorization('dashboard.saidas_totais')){
    ?>
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="float-right mt-2">
                    <i class="fa fa-hand-holding-usd text-danger fa-3x"></i>
                </div>
                <div>
                    <h4 class="mb-1 mt-1"><?php echo MOEDA;?> <span><?php echo number_format($SaidasTotais, 2, ',', '.');?></span></h4>
                    <p class="text-muted mb-0">Saídas Totais</p>
                </div>
                </p>
            </div>
        </div>
    </div> <!-- end col-->
    <?php
    }
    ?>

    <?php
    if($this->permission->Authorization('dashboard.usuarios_cadastrados')){
    ?>
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="float-right mt-2">
                <i class="fa fa-user-plus fa-3x"></i>
                </div>
                <div>
                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $UsuariosCadastrados;?></span></h4>
                    <p class="text-muted mb-0">Usuários Cadastrados</p>
                </div>
                </p>
            </div>
        </div>
    </div> <!-- end col-->
    <?php
    }
    ?>

    <?php
    if($this->permission->Authorization('dashboard.usuarios_ativos')){
    ?>
    <div class="col-md-6 col-xl-3">

        <div class="card">
            <div class="card-body">
                <div class="float-right mt-2">
                    <i class="fa fa-user-check text-info fa-3x"></i>
                </div>
                <div>
                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $UsuariosAtivos;?></span></h4>
                    <p class="text-muted mb-0">Usuários Ativos</p>
                </div>
                </p>
            </div>
        </div>
    </div> <!-- end col-->
    <?php
    }
    ?>

    <?php
    if($this->permission->Authorization('dashboard.saques_pendentes')){
    ?>
    <div class="col-md-6 col-xl-3">

        <div class="card">
            <div class="card-body">
                <div class="float-right mt-2">
                    <i class="fa fa-wallet text-warning fa-3x"></i>
                </div>
                <div>
                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $SaquesPendentes;?></span></h4>
                    <p class="text-muted mb-0">Saques Pendentes</p>
                </div>
                </p>
            </div>
        </div>
    </div> <!-- end col-->
    <?php
    }
    ?>

    <?php
    if($this->permission->Authorization('dashboard.saques_pagos')){
    ?>
    <div class="col-md-6 col-xl-3">

        <div class="card">
            <div class="card-body">
                <div class="float-right mt-2">
                    <i class="fa fa-coins text-success fa-3x"></i>
                </div>
                <div>
                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $SaquesPagos;?></span></h4>
                    <p class="text-muted mb-0">Saques Pagos</p>
                </div>
                </p>
            </div>
        </div>
    </div> <!-- end col-->
    <?php
    }
    ?>

    <?php
    if($this->permission->Authorization('dashboard.faturas_ativas')){
    ?>
    <div class="col-md-6 col-xl-3">

        <div class="card">
            <div class="card-body">
                <div class="float-right mt-2">
                    <i class="fa fa-file-invoice-dollar text-primary fa-3x"></i>
                </div>
                <div>
                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $FaturasAtivas;?></span></h4>
                    <p class="text-muted mb-0">Faturas Ativas</p>
                </div>
                </p>
            </div>
        </div>
    </div> <!-- end col-->
    <?php
    }
    ?>

    <?php
    if($this->permission->Authorization('dashboard.faturas_aberto')){
    ?>
    <div class="col-md-6 col-xl-3">

        <div class="card">
            <div class="card-body">
                <div class="float-right mt-2">
                    <i class="fa fa-receipt text-secondary fa-3x"></i>
                </div>
                <div>
                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $FaturasPendentes;?></span></h4>
                    <p class="text-muted mb-0">Faturas em aberto</p>
                </div>
                </p>
            </div>
        </div>
    </div> <!-- end col-->
    <?php
    }
    ?>

</div> <!-- end row-->

<div class="row">

    <?php
    if($this->permission->Authorization('dashboard.analise_financeira')){
    ?>
    <div class="col-xl-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Análise Financeira</h4>

                <div class="mt-1">
                    <ul class="list-inline main-chart mb-0">
                        <li class="list-inline-item chart-border-left mr-0 border-0">
                            <h3 class="text-primary"><?php echo MOEDA;?> <span data-plugin=""><?php echo number_format($EntradasTotais, 2, ',', '.');?></span><span class="text-muted d-inline-block font-size-15 ml-3">Entradas</span></h3>
                        </li>
                        <li class="list-inline-item chart-border-left mr-0">
                            <h3><?php echo MOEDA;?> <span data-plugin=""><?php echo number_format($SaidasTotais, 2, ',', '.');?></span><span class="text-muted d-inline-block font-size-15 ml-3">Saídas</span>
                            </h3>
                        </li>
                    </ul>
                </div>

                <div class="mt-3">
                    <div id="sales-analytics-chart" class="apex-charts" dir="ltr"></div>
                </div>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col-->
    <?php
    }
    ?>

    <div class="col-xl-4">
        <div class="card bg-primary">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-sm-8">
                        <p class="text-white font-size-18">Precisa de <b>novas funcionalidades?</b> Entre em contato com o programador! <i class="mdi mdi-arrow-right"></i></p>
                        <div class="mt-4">
                            <a href="http://api.whatsapp.com/send?phone=5511947772188" target="_blank" class="btn btn-success waves-effect waves-light">Falar com o Programador</a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mt-4 mt-sm-0">
                            <img src="<?php echo base_url();?>assets/admin/assets/images/setup-analytics-amico.svg" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
            </div> <!-- end card-body-->
        </div> <!-- end card-->

        <?php
        if($this->permission->Authorization('dashboard.saques_plataforma')){
        ?>
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-4">Saques por Plataforma</h4>

                <?php
                if($SaquesPorPlataforma !== false){
                    foreach($SaquesPorPlataforma as $plataforma){

                        $porcentagem = round((($plataforma->quantidade * 100)/$plataforma->total_saques), 2);
                ?>
                <div class="row align-items-center no-gutters mt-3">
                    <div class="col-sm-3">
                        <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-primary mr-2"></i> <?php echo ucwords(ColunaContaRecebimento($plataforma->meio_recebimento));?> </p>
                    </div>

                    <div class="col-sm-9">
                        <div class="progress mt-1" style="height: 6px;">
                            <div class="progress-bar progress-bar bg-<?php echo $cores[$plataforma->meio_recebimento];?>" role="progressbar"
                                style="width: <?php echo $porcentagem;?>%" aria-valuenow="<?php echo $porcentagem;?>" aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                </div> <!-- end row-->
                <?php
                    }
                }else{
                    echo alerts('Nenhum saque feito ainda.', 'info');
                }
                ?>

                
            </div> <!-- end card-body-->
        </div> <!-- end card-->
        <?php
        }
        ?>
    </div> <!-- end Col -->
</div> <!-- end row-->

<div class="row">
    <?php
    if($this->permission->Authorization('dashboard.top_lideres')){
    ?>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">TOP 10 Líderes</h4>

                <div data-simplebar style="max-height: 336px;">
                    <div class="table-responsive">
                        <?php
                        if(!empty($TopLideres)){
                        ?>
                        <table class="table table-borderless table-centered table-nowrap">
                            <tbody>
                                <?php
                                foreach($TopLideres as $lider=>$quantidade){

                                    $statusConta = UserInfo('plano_ativo', $lider);

                                    $rotaUsuarioVisualizar = str_replace(array('(:num)', '(:any)'), array($lider, $lider), $rotas->admin_usuarios_visualizar);
                                ?>
                                <tr>
                                    <td style="width: 20px;"><img src="<?php echo AvatarLoad($lider);?>" class="avatar-xs rounded-circle " alt=""></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">
                                            <a href="<?php echo base_url($rotaUsuarioVisualizar);?>"><?php echo UserInfo('login', $lider);?></a>
                                        </h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="fa fa-male"></i> <?php echo PerfilUsuario(UserInfo('perfil', $lider));?></p>
                                    </td>
                                    <td><span class="badge badge-soft-<?php echo ($statusConta == 1) ? 'success' : 'danger';?> font-size-12"><?php echo ($statusConta == 1) ? 'Conta Ativa' : 'Conta Inativa';?></span></td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i><?php echo $quantidade;?> indicados</td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }else{
                            echo alerts('Nenhum líder encontrado no ranking no momento.', 'info');
                        }
                        ?>
                    </div> <!-- enbd table-responsive-->
                </div> <!-- data-sidebar-->
            </div><!-- end card-body-->
        </div> <!-- end card-->
    </div><!-- end col -->
    <?php
    }
    ?>

    <?php
    if($this->permission->Authorization('dashboard.logs')){
    ?>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">

                <div class="float-right">
                    <div class="">
                        <a href="<?php echo base_url($rotas->admin_logs);?>">
                            <span>Todos os Logs</span>
                        </a>
                    </div>
                </div>

                <h4 class="card-title mb-4">Últimas atividades no admin</h4>

                <ol class="activity-feed mb-0 pl-2" data-simplebar style="max-height: 336px;">
                    
                    <?php
                    if($LogsAdmin !== false){
                        foreach($LogsAdmin as $log){

                            if(date('Y-m-d') == date('Y-m-d', strtotime($log->data_criacao))){
                                $data = 'Hoje';
                            }else{
                                $data = date('d', strtotime($log->data_criacao)).' '.MesExtenso(date('n', strtotime($log->data_criacao)), true).', '.date('Y', strtotime($log->data_criacao));
                            }
                    ?>
                    <li class="feed-item">
                        <div class="feed-item-list">
                            <p class="text-muted mb-1 font-size-13"><?php echo $data;?><small class="d-inline-block ml-1"><?php echo date('H:i', strtotime($log->data_criacao));?></small></p>
                            <p class="mt-0 mb-0"><span class="text-primary">[<?php echo strtolower($log->login);?>]</span> <?php echo $log->log;?></p>
                        </div>
                    </li>
                    <?php
                        }
                    }
                    ?>
                </ol>

            </div>
        </div>
    </div>
    <?php
    }
    ?>
</div>
<!-- end row -->

<?php
if($this->permission->Authorization('dashboard.ultimos_saques')){
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Últimos Saques</h4>
                <div class="table-responsive">
                    <?php
                    if($ListaSaques !== false){
                    ?>
                    <table class="table table-centered table-nowrap mb-0">
                        <thead class="thead-light">
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Data Solicitação</th>
                                <th>Data Máxima de Recebimento</th>
                                <th>Valor</th>
                                <th>Receber em</th>
                                <th>Detalhes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($ListaSaques as $saque){
                            ?>
                            <tr>
                                <td><a href="javascript: void(0);" class="text-body font-weight-bold">#<?php echo $saque->id;?></a> </td>
                                <td><?php echo $saque->nome;?> (<?php echo $saque->login;?>)</td>
                                <td>
                                    <?php echo date('d', strtotime($saque->data_solicitacao)); ?> de
                                    <?php echo MesExtenso(date('n', strtotime($saque->data_solicitacao))); ?>, 
                                    <?php echo date('Y', strtotime($saque->data_solicitacao)); ?>
                                </td>
                                <td>
                                    <?php
                                    $novoLimite = DiasUteis($saque->data_solicitacao, $diasUteis);
                                    $dataLimite = date('d', strtotime($novoLimite)).' de '.MesExtenso(date('n', strtotime($novoLimite))).', '.date('Y', strtotime($novoLimite));
                                    
                                    if($novoLimite == date('Y-m-d')){
                                        $icon = 'exclamation';
                                        $color = 'warning';
                                    }elseif(date('Y-m-d') > $novoLimite){
                                        $icon = 'times';
                                        $color = 'danger';
                                    }else{
                                        $icon = 'check';
                                        $color = 'success';
                                    }
                                    ?>
                                    <span class="badge badge-pill badge-soft-<?php echo $color;?> font-size-12">
                                        <i class="fa fa-<?php echo $icon;?>"></i> <?php echo $dataLimite;?>
                                    </span>
                                </td>
                                <td>
                                    <?php echo MOEDA;?> <?php echo number_format($saque->valor_receber, 2, ',', '.');?>
                                </td>
                                <td>
                                    <i class="fab fa-cc-mastercard mr-1"></i> <?php echo strtoupper(ColunaContaRecebimento($saque->meio_recebimento));?>
                                </td>
                                <td>
                                    <?php
                                    $rotaSaqueVisualizar = str_replace(array('(:num)', '(:any)'), array($saque->id, $saque->id), $rotas->admin_saques_visualizar);
                                    ?>
                                    <a href="<?php echo base_url($rotaSaqueVisualizar);?>" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                        Visualizar
                                    </a>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                    }else{
                        echo alerts('Nenhum saque feito até o momento.', 'info');
                    }
                    ?>
                </div>
                <!-- end table-responsive -->
            </div>
        </div>
    </div>
</div>
<!-- end row -->
<?php
}
?>