<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-right mt-2">
                                    <i class="fa fa-dollar-sign text-success fa-3x"></i>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><?php echo MOEDA; ?> <span><?php echo number_format($EntradasTotais, 2, ',', '.'); ?></span></h4>
                                    <p class="text-muted mb-0">Entradas nas contas</p>
                                </div>
                                </p>
                            </div>
                        </div>
                    </div> <!-- end col-->
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-right mt-2">
                                    <i class="fa fa-hand-holding-usd text-danger fa-3x"></i>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><?php echo MOEDA; ?> <span><?php echo number_format(($SaidasTotais - $CustosEmpresa - $SaidaPablo - $SaidaLois - $SaidaWalerio - $SaidaBada - $SaidaAlisson - $SaidaErick), 2, ',', '.'); ?></span></h4>
                                    <p class="text-muted mb-0">Saídas nas contas</p>
                                </div>
                                </p>
                            </div>
                        </div>
                    </div> <!-- end col-->
                    <div class="col-md-6 col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-right mt-2">
                                    <i class="fa fa-piggy-bank text-secondary fa-3x"></i>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><?php echo MOEDA; ?> <span><?php echo number_format(($EntradasTotais - $SaidasTotais), 2, ',', '.'); ?></span></h4>
                                    <p class="text-muted mb-0">CAIXA ATUAL</p>
                                </div>
                                </p>
                            </div>
                        </div>
                    </div> <!-- end col-->
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-right mt-2">
                                    <i class="fa fa-hand-holding-usd text-danger fa-3x"></i>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><?php echo MOEDA; ?> <span><?php echo number_format($CustosEmpresa, 2, ',', '.'); ?></span></h4>
                                    <p class="text-muted mb-0">Custos da Empresa</p>
                                </div>
                                </p>
                            </div>
                        </div>
                    </div> <!-- end col-->
                </div>

                <h4 class="card-title">Visão Geral - <?php echo $nome_pagina; ?></h4>
                <p class="card-title-desc">
                    Todos os registros de entradas e saídas do sistema <br />
                    <strong class="text-warning">* Lembramos que por ser um registro essencial ao funcionamento do sistema, depois de incluído o registro, não será possível editar e nem remover.</strong>
                </p>

                <hr />

                <div>

                    <?php if ($this->session->flashdata('caixa_message')) echo $this->session->flashdata('caixa_message'); ?>

                    <div class="table-responsive">

                        <?php
                        if ($permitidoAdicionar) {
                        ?>
                            <a href="<?php echo base_url($rotas->admin_caixa_adicionar); ?>" class="btn btn-success mb-4"><i class="fa fa-plus"></i> Adicionar Registro</a>

                        <?php
                        }
                        ?>


                        <?php
                        if ($registros !== false) {
                        ?>
                            <table id="" class="table table-striped simpletable_order_by_0_desc">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Registro</th>
                                        <th>Tipo</th>
                                        <th>Valor</th>
                                        <th>Registrado por</th>
                                        <th>IP</th>
                                        <th>Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($registros as $registro) {

                                        if ($registro->tipo == 1) {
                                            $text = 'Entrada';
                                            $color = 'success';
                                        } elseif ($registro->tipo == 2) {
                                            $text = 'Saída';
                                            $color = 'danger';
                                        } elseif ($registro->tipo == 3) {
                                            $text = 'Custos da Empresa';
                                            $color = 'primary';
                                        }
                                    ?>
                                        <tr>
                                            <th><?php echo $registro->id; ?></th>
                                            <td><span class="text-<?php echo $color; ?>"><?php echo $registro->registro; ?></span></td>
                                            <td><span class="badge badge-<?php echo $color; ?>"><?php echo $text; ?></span></td>
                                            <td><?php echo number_format($registro->valor, 2, ',', '.'); ?></td>
                                            <td>
                                                <?php
                                                if (is_null($registro->id_usuario_admin) || empty($registro->id_usuario_admin)) {
                                                    echo 'Pelo sistema';
                                                } else {
                                                    echo UserInfo('login', $registro->id_usuario_admin);
                                                }
                                                ?>
                                            </td>
                                            <td><a href="https://tools.keycdn.com/geo?host=<?php echo $registro->ip; ?>" target="_blank"><?php echo $registro->ip; ?></a></td>
                                            <td><?php echo date('d/m/Y H:i:s', strtotime($registro->data_criacao)); ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        <?php
                        } else {
                            echo alerts('Não há nenhum registro no caixa da empresa.', 'info');
                        }
                        ?>
                    </div>

                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->