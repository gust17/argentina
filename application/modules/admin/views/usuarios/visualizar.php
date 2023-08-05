<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Detalhes de conta</h4>
                <p class="card-title-desc">Detalhes da conta do usuário selecionado.</p>

                <?php
                if(EnabledMasterKey()){
                    $rotaUsuarioBackoffice = str_replace(array('(:num)', '(:any)'), array($idUser, $idUser), $rotas->admin_usuarios_backoffice);
                    $rotaUsuarioEditar = str_replace(array('(:num)', '(:any)'), array($idUser, $idUser), $rotas->admin_usuarios_editar);
                ?>
                <a href="<?php echo base_url($rotaUsuarioBackoffice);?>" class="btn btn-warning" target="_blank">Backoffice</a>
                <a href="<?php echo base_url($rotaUsuarioEditar);?>" class="btn btn-info">Editar Usuário</a>
                <br /><br />
                <?php
                }
                ?>

                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#dados" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-user"></i></span>
                            <span class="d-none d-sm-block">Dados</span> 
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#rede" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-users"></i></span>
                            <span class="d-none d-sm-block">Rede</span> 
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#contas" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-university"></i></span>
                            <span class="d-none d-sm-block">Contas</span> 
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#extrato" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-list"></i></span>
                            <span class="d-none d-sm-block">Extrato</span>   
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#faturas" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-file-invoice-dollar"></i></span>
                            <span class="d-none d-sm-block">Faturas</span>    
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#saques" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-dollar-sign"></i></span>
                            <span class="d-none d-sm-block">Saques</span>    
                        </a>
                    </li>
                    <?php
                    if(EnabledMasterKey()){
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#codigos" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-qrcode"></i></span>
                            <span class="d-none d-sm-block">Cód. BankOn</span>    
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#notificacoes" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-exclamation-triangle"></i></span>
                            <span class="d-none d-sm-block">Notificações</span>    
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#logs" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-file"></i></span>
                            <span class="d-none d-sm-block">Logs</span>    
                        </a>
                    </li>
                    <?php
                    }
                    ?>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active" id="dados" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <td><strong>Login</strong></td>
                                    <td>
                                    <?php echo $usuario->login;?>
                                    <sup>
                                        <?php
                                        if($usuario->status == 1){
                                            $color = 'success';
                                            $text = 'Conta Ativa';
                                        }else{
                                            $color = 'danger';
                                            $text = 'Conta Inativa';
                                        }
                                        ?>
                                        <span class="badge badge-<?php echo $color;?>"><?php echo $text;?></span>
                                    </sup>
                                    <sup>
                                        <?php
                                        if($usuario->plano_ativo == 1){
                                            $color = 'success';
                                            $text = 'Plano Ativo';
                                        }else{
                                            $color = 'danger';
                                            $text = 'Nenhum Plano';
                                        }
                                        ?>
                                        <span class="badge badge-<?php echo $color;?>"><?php echo $text;?></span>
                                    </sup>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Saque Liberado</strong></td>
                                    <td>
                                        <?php echo ($usuario->saque_liberado == 1) ? 'Sim' : 'Não';?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Status da Conta</strong></td>
                                    <td>
                                        <?php echo ($usuario->status == 1) ? 'Liberada para uso' : 'Bloqueada';?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Motivo do Status</strong></td>
                                    <td>
                                        <?php echo $usuario->status_mensagem;?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>TIPO DE CADASTRO</strong></td>
                                    <td>
                                        <?php echo TipoCadastro($usuario->tipo_cadastro);?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nome</td>
                                    <td><?php echo $usuario->nome;?></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><?php echo $usuario->email;?></td>
                                </tr>
                                <tr>
                                    <td>Celular</td>
                                    <td><?php echo $usuario->ddi;?> <?php echo $usuario->celular;?></td>
                                </tr>
                                <tr>
                                    <td>Documento</td>
                                    <td><?php echo $usuario->documento;?></td>
                                </tr>
                                <tr>
                                    <td>Nascimento</td>
                                    <td>
                                    <?php
                                    if(!is_null($usuario->data_nascimento) && !empty($usuario->data_nascimento)){
                                        echo date('d/m/Y', strtotime($usuario->data_nascimento));
                                    }else{
                                        echo 'Não informado';
                                    }
                                    ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sexo</td>
                                    <td><?php echo MeuSexo($usuario->sexo);?></td>
                                </tr>
                                <tr>
                                    <td>Score</td>
                                    <td><?php echo number_format($usuario->score, 0, '', '.');?> pontos</td>
                                </tr>
                                <tr>
                                    <td>CEP</td>
                                    <td><?php echo $usuario->cep;?></td>
                                </tr>
                                <tr>
                                    <td>Endereço</td>
                                    <td><?php echo $usuario->endereco;?></td>
                                </tr>
                                <tr>
                                    <td>Bairro</td>
                                    <td><?php echo $usuario->bairro;?></td>
                                </tr>
                                <tr>
                                    <td>Cidade</td>
                                    <td><?php echo $usuario->cidade;?></td>
                                </tr>
                                <tr>
                                    <td>Estado</td>
                                    <td><?php echo $usuario->estado;?></td>
                                </tr>
                                <tr>
                                    <td>Último Login</td>
                                    <td><?php echo (!is_null($usuario->ultimo_login)) ? date('d/m/Y H:i:s', strtotime($usuario->ultimo_login)) : 'Não logou na conta ainda';?></td>
                                </tr>
                                <tr>
                                    <td>Data do cadastro</td>
                                    <td><?php echo date('d/m/Y H:i:s', strtotime($usuario->data_cadastro));?></td>
                                </tr>
                                <tr>
                                    <td>Última atualização cadastral</td>
                                    <td><?php echo (!is_null($usuario->data_atualizacao)) ? date('d/m/Y H:i:s', strtotime($usuario->data_atualizacao)) : 'Não atualizado';?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="rede" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <td>Patrocinador Direto</td>
                                    <td><?php echo UserInfo('login', $rede->id_patrocinador_direto);?></td>
                                </tr>
                                <tr>
                                    <td>Patrocinador Rede</td>
                                    <td><?php echo UserInfo('login', $rede->id_patrocinador_rede);?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="contas" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <td>Carteira Bitcoin</td>
                                    <td>
                                    <?php
                                    if(!is_null($usuario->carteira_bitcoin) && !empty($usuario->carteira_bitcoin) && $usuario->carteira_bitcoin != '{}'){
                                        $carteira = json_decode($usuario->carteira_bitcoin);

                                        echo $carteira->carteira_bitcoin;
                                    }else{
                                        echo 'Não Cadastrada';
                                    }
                                    ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>BankOn</td>
                                    <td>
                                    <?php
                                    if(!is_null($usuario->bankon) && !empty($usuario->bankon) && $usuario->bankon != '{}'){
                                        $bankon = json_decode($usuario->bankon);

                                        echo $bankon->bankon;
                                    }else{
                                        echo 'Não cadastrada';
                                    }
                                    ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>NewPay</td>
                                    <td>
                                    <?php
                                    if(!is_null($usuario->newpay) && !empty($usuario->newpay) && $usuario->newpay != '{}'){
                                        $newpay = json_decode($usuario->newpay);

                                        echo $newpay->newpay;
                                    }else{
                                        echo 'Não cadastrada';
                                    }
                                    ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Conta Bancária</td>
                                    <td>
                                    <?php
                                    if(!is_null($usuario->conta_bancaria) && !empty($usuario->conta_bancaria) && $usuario->conta_bancaria != '{}'){
                                        $conta_bancaria = json_decode($usuario->conta_bancaria);

                                        echo 'Banco: '.BancoID($conta_bancaria->banco).'<br />';
                                        echo 'Agência: '.$conta_bancaria->agencia.'<br />';
                                        echo 'Conta: '.$conta_bancaria->conta.'<br />';
                                        echo 'Tipo de Conta: '.($conta_bancaria->tipo == 1) ? 'Conta Corrente' : 'Conta Poupança'.'<br />';
                                        echo 'Titular: '.$conta_bancaria->titular.'<br />';
                                        echo 'Documento: '.$conta_bancaria->documento;
                                    }else{
                                        echo 'Não cadastrada';
                                    }
                                    ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Chave Pix</td>
                                    <td>
                                    <?php
                                    if(!is_null($usuario->pix) && !empty($usuario->pix) && $usuario->pix != '{}'){
                                        $pix = json_decode($usuario->pix);

                                        ?>
                                        Nome: <?= $pix->nombre ?> <br>
                                        DNI: <?= $pix->dni ?> <br>
                                        Conta: <?= $pix->cuenta ?> <br>
                                        CCI: <?= $pix->cci ?> <br>

                                        <?php

                                    }else{
                                        echo 'Não cadastrada';
                                    }
                                    ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="extrato" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table simpletable_order_by_0_desc">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Descrição</th>
                                        <th>Valor</th>
                                        <th>Tipo</th>
                                        <th>Saldo</th>
                                        <th>Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($transacoes !== false){
                                        foreach($transacoes as $transacao){
                                    ?>
                                    <tr>
                                        <td><?php echo $transacao->id;?></td>
                                        <td class="text-<?php echo ($transacao->tipo_saldo == 1) ? 'success' : 'danger';?>"><?php echo $transacao->descricao;?></td>
                                        <td><?php echo MOEDA;?> <?php echo number_format($transacao->valor, 2, ',', '.');?></td>
                                        <td><span class="badge badge-<?php echo ($transacao->tipo_saldo == 1) ? 'success' : 'danger';?> badge-pill"><?php echo TipoExtrato($transacao->tipo_saldo);?></span></td>
                                        <td><?php echo CategoriaExtrato($transacao->categoria);?></td>
                                        <td><?php echo date('d/m/Y H:i:s', strtotime($transacao->data_criacao));?></td>
                                    </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="faturas" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered simpletable_order_by_0_desc">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Plano</th>
                                        <th>Valor</th>
                                        <th>Final de semana</th>
                                        <th>Porcentagem</th>
                                        <th>Pagamentos</th>
                                        <th>Liberados</th>
                                        <th>Cortesia</th>
                                        <th>Meio de Pagamento</th>
                                        <th>Detalhes Pag.</th>
                                        <th>Raiz Sacada</th>
                                        <th>Status</th>
                                        <th>Gerada em</th>
                                        <th>Pago em</th>
                                        <th>Primeiro Recebimento</th>
                                        <th>Último Pagamento</th>
                                        <th>Expirado em</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($faturas !== false){
                                        foreach($faturas as $fatura){
                                    ?>
                                    <tr>
                                        <td><?php echo $fatura->id;?></td>
                                        <td><?php echo PlanInfo($fatura->id_plano, 'nome');?></td>
                                        <td><?php echo MOEDA;?> <?php echo number_format($fatura->valor, 2, ',', '.');?></td>
                                        <td><?php echo ($fatura->dia_util == 1) ? 'Sim' : 'Não';?></td>
                                        <td><?php echo $fatura->percentual_pago;?>%</td>
                                        <td><?php echo $fatura->quantidade_pagamentos_realizados;?> / <?php echo $fatura->quantidade_pagamentos_fazer;?></td>
                                        <td><?php echo MOEDA;?> <?php echo number_format($fatura->valor_liberado, 2, ',', '.');?></td>
                                        <td><?php echo ($fatura->cortesia == 1) ? 'Sim' : 'Não';?></td>
                                        <td><?php echo $fatura->meio_pagamento;?></td>
                                        <td><?php echo $fatura->meio_pagamento_detalhes;?></td>
                                        <td><?php echo ($fatura->status_saque_raiz == 1) ? 'Sim' : 'Não';?></td>
                                        <td>
                                        <?php
                                        if($fatura->status == 0){
                                            $text = 'Pendente';
                                            $color = 'warning';
                                        }elseif($fatura->status == 1){
                                            $text = 'Pago';
                                            $color = 'success';
                                        }else{
                                            $text = 'Expirado';
                                            $color = 'danger';
                                        }
                                        ?>
                                        <span class="badge badge-<?php echo $color;?>"><?php echo $text;?></span>
                                        </td>
                                        <td><?php echo date('d/m/Y H:i:s', strtotime($fatura->data_criacao));?></td>
                                        <td><?php echo (!is_null($fatura->data_pagamento) && !empty($fatura->data_pagamento)) ? date('d/m/Y H:i:s', strtotime($fatura->data_pagamento)) : '';?></td>
                                        <td><?php echo (!is_null($fatura->data_primeiro_recebimento) && !empty($fatura->data_primeiro_recebimento)) ? date('d/m/Y H:i:s', strtotime($fatura->data_primeiro_recebimento)) : '';?></td>
                                        <td><?php echo (!is_null($fatura->data_ultimo_pagamento_feito) && !empty($fatura->data_ultimo_pagamento_feito)) ? date('d/m/Y H:i:s', strtotime($fatura->data_ultimo_pagamento_feito)) : '';?></td>
                                        <td><?php echo (!is_null($fatura->data_expiracao) && !empty($fatura->data_expiracao)) ? date('d/m/Y H:i:s', strtotime($fatura->data_expiracao)) : '';?></td>
                                    </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="saques" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered simpletable_order_by_0_desc">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tipo de saque</th>
                                        <th>Valor solicitado</th>
                                        <th>Valor a receber</th>
                                        <th>Data da solicitação</th>
                                        <th>Limite para recebimento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($saques !== false){
                                    foreach($saques as $saque){

                                        $dataDiasUteis = DiasUteis($saque->data_solicitacao, $dias_pagamento_saque);
                                        $horarioSolicitacao = date('H:i:s', strtotime($saque->data_solicitacao));

                                        $dataLimite = date('d/m/Y', strtotime($dataDiasUteis)).' '.$horarioSolicitacao;
                                ?>
                                <tr>
                                    <td><?php echo $saque->id;?></td>
                                    <td><?php echo CategoriaExtrato($saque->tipo_saque);?></td>
                                    <td><?php echo MOEDA;?> <?php echo number_format($saque->valor_solicitado, 2, ',', '.');?></td>
                                    <td><?php echo MOEDA;?> <?php echo number_format($saque->valor_receber, 2, ',', '.');?></td>
                                    <td><?php echo date('d/m/Y H:i:s', strtotime($saque->data_solicitacao));?></td>
                                    <td><?php echo $dataLimite;?></td>
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="tab-pane" id="codigos" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered simpletable_order_by_0_desc">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Plano</th>
                                        <th>BankOn</th>
                                        <th>Código</th>
                                        <th>Data da Transação</th>
                                        <th>Data da Utilização</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($codigos_bankon !== false){
                                    foreach($codigos_bankon as $codigos){
                                ?>
                                <tr>
                                    <td><?php echo $codigos->id;?></td>
                                    <td><?php echo $codigos->nome;?> (R$ <?php echo number_format($codigos->valor, 2, ',', '.');?>)</td>
                                    <td><?php echo $codigos->bankon;?></td>
                                    <td><?php echo $codigos->codigo;?></td>
                                    <td><?php echo date('d/m/Y H:i:s', strtotime($codigos->data_transacao));?></td>
                                    <td><?php echo date('d/m/Y H:i:s', strtotime($codigos->data_utilizacao));?></td>
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="notificacoes" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered simpletable_order_by_0_desc">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Notificação</th>
                                        <th>Visualizado</th>
                                        <th>IP</th>
                                        <th>Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($notificacoes !== false){
                                    foreach($notificacoes as $notificacao){
                                ?>
                                <tr>
                                    <td><?php echo $notificacao->id;?></td>
                                    <td><?php echo $notificacao->notificacao;?></td>
                                    <td><?php echo ($notificacao->visualizado == 1) ? 'Sim' : 'Não';?></td>
                                    <td><a href="https://tools.keycdn.com/geo?host=<?php echo $notificacao->ip;?>" target="_blank"><?php echo $notificacao->ip;?></a></td>
                                    <td><?php echo date('d/m/Y H:i:s', strtotime($notificacao->data_criacao));?></td>
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="logs" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered simpletable_order_by_0_desc">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Log</th>
                                        <th>IP</th>
                                        <th>Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($logs !== false){
                                    foreach($logs as $log){
                                ?>
                                <tr>
                                    <td><?php echo $log->id;?></td>
                                    <td><?php echo $log->log;?></td>
                                    <td><a href="https://tools.keycdn.com/geo?host=<?php echo $log->ip;?>" target="_blank"><?php echo $log->ip;?></a></td>
                                    <td><?php echo date('d/m/Y H:i:s', strtotime($log->data_criacao));?></td>
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->