<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Detalhes de conta</h4>
                <p class="card-title-desc">Detalhes da conta do usuário selecionado.</p>

                <?php if(isset($message)) echo $message ;?>

                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#dados" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-user"></i></span>
                            <span class="d-none d-sm-block">Geral</span> 
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
                        <a class="nav-link" data-toggle="tab" href="#codigos" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-qrcode"></i></span>
                            <span class="d-none d-sm-block">Cód. Bankon</span>    
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#admin" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-qrcode"></i></span>
                            <span class="d-none d-sm-block">Admin</span>    
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active" id="dados" role="tabpanel">
                        <form action="" method="post">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td><strong>Tipo de Cadastro</strong></td>
                                        <td>
                                        <select name="tipo_cadastro" class="form-control">
                                        <?php
                                        foreach(TiposCadastro() as $nTipo=>$tipo){

                                            $selected = ($nTipo == $usuario->tipo_cadastro) ? 'selected' : '';
                                        ?>
                                        <option value="<?php echo $nTipo;?>" <?php echo $selected;?>><?php echo $tipo;?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>    
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Login</strong></td>
                                        <td><input type="text" name="login" class="form-control" value="<?php echo $usuario->login;?>" required /></td>
                                    </tr>
                                    <tr>
                                        <td><strong>NOVA SENHA</strong></td>
                                        <td><input type="password" name="senha" class="form-control" value="" autocomplete="off" /></td>
                                    </tr>
                                    <tr>
                                        <td>Nome</td>
                                        <td><input type="text" name="nome" class="form-control" value="<?php echo $usuario->nome;?>" required /></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td><input type="email" name="email" class="form-control" value="<?php echo $usuario->email;?>" required /></td>
                                    </tr>
                                    <tr>
                                        <td>Documento</td>
                                        <td><input type="text" name="documento" class="form-control" value="<?php echo $usuario->documento;?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Celular</td>
                                        <td>
                                        <select name="ddi">
                                            <?php
                                            foreach($ddis as $ddi){
                                                $selected = ($ddi->code == $usuario->ddi) ? 'selected' : '';
                                                echo '<option value="'.$ddi->code.'" '.$selected.'>'.$ddi->code.' - '.$ddi->name.'</option>';
                                            }
                                            ?>
                                        </select>
                                            <input type="text" name="celular" class="form-control" value="<?php echo $usuario->celular;?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nascimento</td>
                                        <td><input type="text" name="data_nascimento" class="form-control" value="<?php echo date('d/m/Y', strtotime($usuario->data_nascimento));?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Sexo</td>
                                        <td>
                                            <select name="sexo" class="form-control">
                                                <option value="1" <?php echo ($usuario->sexo == 1) ? 'selected' : '';?>>Sexo Masculino</option>
                                                <option value="2" <?php echo ($usuario->sexo == 2) ? 'selected' : '';?>>Sexo Feminino</option>
                                                <option value="3" <?php echo ($usuario->sexo == 3) ? 'selected' : '';?>>Prefiro não informar</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>CEP</td>
                                        <td><input type="text" name="cep" class="form-control" value="<?php echo $usuario->cep;?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Endereço</td>
                                        <td><input type="text" name="endereco" class="form-control" value="<?php echo $usuario->endereco;?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Bairro</td>
                                        <td><input type="text" name="bairro" class="form-control" value="<?php echo $usuario->bairro;?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Cidade</td>
                                        <td><input type="text" name="cidade" class="form-control" value="<?php echo $usuario->cidade;?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Estado</td>
                                        <td><input type="text" name="estado" class="form-control" value="<?php echo $usuario->estado;?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Score</td>
                                        <td><input type="text" name="score" class="form-control" value="<?php echo $usuario->score;?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Saque Liberado</td>
                                        <td>
                                            <select name="saque_liberado" class="form-control">
                                                <option value="0" <?php echo ($usuario->saque_liberado == 0) ? 'selected' : '';?>>Não</option>
                                                <option value="1" <?php echo ($usuario->saque_liberado == 1) ? 'selected' : '';?>>Sim</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Status da Conta</td>
                                        <td>
                                            <select name="status" class="form-control">
                                                <option value="1" <?php echo ($usuario->status == 1) ? 'selected' : '';?>>Liberada para uso</option>
                                                <option value="2" <?php echo ($usuario->status == 2) ? 'selected' : '';?>>Bloqueada</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Motivo do Status <small>(quando bloqueada)</small></td>
                                        <td>
                                            <textarea cols="47" rows="7" class="form-control" name="status_mensagem"><?php echo $usuario->status_mensagem;?></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                            <button type="submit" name="submitDados" value="Atualizar" class="btn btn-success btn-block">Atualizar Dados</button>
                        </form>
                    </div>
                    <div class="tab-pane" id="rede" role="tabpanel">
                        <form action="" method="post">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td>Patrocinador Direto</td>
                                        <td><input type="text" name="patrocinador_direto" class="form-control" value="<?php echo UserInfo('login', $rede->id_patrocinador_direto);?>" required /></td>
                                    </tr>
                                    <tr>
                                        <td>Patrocinador Rede</td>
                                        <td><input type="text" name="patrocinador_rede" class="form-control" value="<?php echo UserInfo('login', $rede->id_patrocinador_rede);?>" required /></td>
                                    </tr>
                                </table>
                            </div>
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                            <button type="submit" name="submitRede" value="Atualizar" class="btn btn-success btn-block">Atualizar Patrocinadores</button>
                        </form>
                    </div>
                    <div class="tab-pane" id="contas" role="tabpanel">
                        <form action="" method="post">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td>Carteira Bitcoin</td>
                                        <td>
                                            <?php
                                            $carteira_btc = $usuario->carteira_bitcoin;
                                            if(!is_null($carteira_btc) && !empty($carteira_btc) && $carteira_btc != '{}'){
                                                $carteira_btc = json_decode($carteira_btc);
                                                $carteira_btc = $carteira_btc->carteira_bitcoin;
                                            }else{
                                                $carteira_btc = '';
                                            }
                                            ?>
                                            <input type="text" name="carteira_bitcoin" class="form-control" value="<?php echo $carteira_btc;?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>BankOn</td>
                                        <td>
                                            <?php
                                            $bankon = $usuario->bankon;
                                            if(!is_null($bankon) && !empty($bankon) && $bankon != '{}'){
                                                $bankon = json_decode($bankon);
                                                $bankon = $bankon->bankon;
                                            }else{
                                                $bankon = '';
                                            }
                                            ?>
                                            <input type="text" name="bankon" class="form-control" value="<?php echo $bankon;?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>NewPay</td>
                                        <td>
                                            <?php
                                            $newpay = $usuario->newpay;
                                            if(!is_null($newpay) && !empty($newpay) && $newpay != '{}'){
                                                $newpay = json_decode($newpay);
                                                $newpay = $newpay->newpay;
                                            }else{
                                                $newpay = '';
                                            }
                                            ?>
                                            <input type="text" name="newpay" class="form-control" value="<?php echo $newpay;?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Conta Bancária</td>
                                        <td>
                                        <?php

                                        $banco = '';
                                        $agencia = '';
                                        $conta = '';
                                        $conta_tipo = '';
                                        $titular = '';
                                        $documento = '';

                                        if(!is_null($usuario->conta_bancaria) && !empty($usuario->conta_bancaria) && $usuario->conta_bancaria != '{}'){
                                            $conta_bancaria = json_decode($usuario->conta_bancaria);

                                            $banco = $conta_bancaria->banco;
                                            $agencia = $conta_bancaria->agencia;
                                            $conta = $conta_bancaria->conta;
                                            $conta_tipo = $conta_bancaria->tipo;
                                            $titular = $conta_bancaria->titular;
                                            $documento = $conta_bancaria->documento;
                                        }
                                        ?>
                                        <select name="banco" class="form-control mb-2">
                                            <?php
                                            foreach($lista_bancos as $idBanco=>$banco){

                                                $selected = ($idBanco == $banco) ? 'selected' : '';

                                                echo '<option value="'.$idBanco.'" '.$selected.'>'.$banco.'</option>';
                                            }
                                            ?>
                                        </select>
                                        <input type="text" name="agencia" class="form-control mb-2" placeholder="Agência" value="<?php echo $agencia;?>" />
                                        <input type="text" name="conta" class="form-control mb-2" placeholder="Conta" value="<?php echo $conta;?>" />
                                        <select name="conta_tipo" class="form-control mb-2">
                                            <option value="1" <?php echo ($conta_tipo == 1) ? 'selected' : '';?>>Conta Corrente</option>
                                            <option value="2" <?php echo ($conta_tipo == 2) ? 'selected' : '';?>>Conta Poupança</option>
                                        </select>
                                        <input type="text" name="titular" class="form-control mb-2" placeholder="Titular" value="<?php echo $titular;?>" />
                                        <input type="text" name="documento" class="form-control mb-2" placeholder="Documento" value="<?php echo $documento;?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Chave Pix</td>
                                        <td>
                                            <?php
                                            $pix = $usuario->pix;
                                            if(!is_null($pix) && !empty($pix) && $pix != '{}'){
                                                $pix = json_decode($pix);
                                                $pix = $pix->pix;
                                            }else{
                                                $pix = '';
                                            }
                                            ?>
                                            <input type="text" name="pix" class="form-control mb-2" value="<?php echo $pix;?>" />
                                            <select name="pix_banco" class="form-control" required>
                                            <?php
                                            foreach(ListaBancos() as $codigo=>$banco){

                                                $selected = (isset($pix['banco']) && $pix['banco'] == $codigo) ? 'selected' : '';

                                                echo '<option value="'.$codigo.'" '.$selected.'>'.$codigo.' - '.$banco.'</option>';
                                            }
                                            ?>
                                        </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                            <button type="submit" name="submitContas" value="Atualizar" class="btn btn-success btn-block">Atualizar Contas de Depósito</button>
                        </form>
                    </div>
                    <div class="tab-pane" id="extrato" role="tabpanel">
                        <div class="table-responsive">

                            <a href="javascript:void(0);" data-toggle="modal" data-target=".add-extrato" data-userid="<?php echo $this->uri->segment(4);?>" class="btn clickAddRecordExtract btn-success mb-4"><i class="fa fa-plus"></i> Adicionar Registro no Extrato</a>

                            <table class="table simpletable_order_by_0_desc">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Ação</th>
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
                                    <tr data-extract-block-ref="<?php echo $transacao->id;?>">
                                        <td><?php echo $transacao->id;?></td>
                                        <td>
                                            <a href="javascript:void(0)" data-ref="<?php echo $transacao->id;?>" class="btn btn-danger excluirExtrato">Excluir</a>
                                            <a href="javascript:void(0)" data-ref="<?php echo $transacao->id;?>" data-toggle="modal" data-target=".editar-extrato" class="btn btn-info editarExtrato">Editar</a>
                                        </td>
                                        <td class="descricao_extrato text-<?php echo ($transacao->tipo_saldo == 1) ? 'success' : 'danger';?>"><?php echo $transacao->descricao;?></td>
                                        <td class="valor_extrato"><?php echo MOEDA;?> <?php echo number_format($transacao->valor, 2, ',', '.');?></td>
                                        <td class="tipo_extrato"><span class="badge badge-<?php echo ($transacao->tipo_saldo == 1) ? 'success' : 'danger';?> badge-pill"><?php echo TipoExtrato($transacao->tipo_saldo);?></span></td>
                                        <td class="categoria_extrato"><?php echo CategoriaExtrato($transacao->categoria);?></td>
                                        <td class="data_criacao_extrato"><?php echo date('d/m/Y H:i:s', strtotime($transacao->data_criacao));?></td>
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
                                        <th>Ação</th>
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
                                    <tr data-invoice-block-ref="<?php echo $fatura->id;?>">
                                        <td><?php echo $fatura->id;?></td>
                                        <td>
                                            <a href="javascript:void(0);" data-toggle="modal" data-target=".editar-fatura" data-ref="<?php echo $fatura->id;?>" class="btn editarFaturaLoad btn-info mb-4">Editar</a>
                                        </td>
                                        <td class="nome_plano"><?php echo PlanInfo($fatura->id_plano, 'nome');?></td>
                                        <td class="valor"><?php echo MOEDA;?> <?php echo number_format($fatura->valor, 2, ',', '.');?></td>
                                        <td class="dia_util"><?php echo ($fatura->dia_util == 1) ? 'Sim' : 'Não';?></td>
                                        <td class="percentual_pago"><?php echo $fatura->percentual_pago;?>%</td>
                                        <td class="pagamentos"><?php echo $fatura->quantidade_pagamentos_realizados;?> / <?php echo $fatura->quantidade_pagamentos_fazer;?></td>
                                        <td class="valor_liberado"><?php echo MOEDA;?> <?php echo number_format($fatura->valor_liberado, 2, ',', '.');?></td>
                                        <td class="cortesia"><?php echo ($fatura->cortesia == 1) ? 'Sim' : 'Não';?></td>
                                        <td class="meio_pagamento"><?php echo $fatura->meio_pagamento;?></td>
                                        <td class="meio_pagamento_detalhes"><?php echo $fatura->meio_pagamento_detalhes;?></td>
                                        <td class="status_raiz"><?php echo ($fatura->status_saque_raiz == 1) ? 'Sim' : 'Não';?></td>
                                        <td class="status_fatura">
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
                                        <td class="data_criacao"><?php echo date('d/m/Y H:i:s', strtotime($fatura->data_criacao));?></td>
                                        <td class="data_pagamento"><?php echo (!is_null($fatura->data_pagamento) && !empty($fatura->data_pagamento)) ? date('d/m/Y H:i:s', strtotime($fatura->data_pagamento)) : '';?></td>
                                        <td class="data_primeiro_recebimento"><?php echo (!is_null($fatura->data_primeiro_recebimento) && !empty($fatura->data_primeiro_recebimento)) ? date('d/m/Y H:i:s', strtotime($fatura->data_primeiro_recebimento)) : '';?></td>
                                        <td class="data_ultimo_pagamento"><?php echo (!is_null($fatura->data_ultimo_pagamento_feito) && !empty($fatura->data_ultimo_pagamento_feito)) ? date('d/m/Y H:i:s', strtotime($fatura->data_ultimo_pagamento_feito)) : '';?></td>
                                        <td class="data_expiracao"><?php echo (!is_null($fatura->data_expiracao) && !empty($fatura->data_expiracao)) ? date('d/m/Y H:i:s', strtotime($fatura->data_expiracao)) : '';?></td>
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
                                        <th>Ação</th>
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
                                <tr data-block-code-id="<?php echo $codigos->id;?>">
                                    <td><?php echo $codigos->id;?></td>
                                    <td><a href="javascript:void(0);" data-id="<?php echo $codigos->id;?>" class="excluirCodigo btn btn-danger">Excluir</a></td>
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
                    <div class="tab-pane" id="admin" role="tabpanel">
                        <form action="" method="post">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered simpletable_order_by_0_desc">
                                    <tr>
                                        <td>É administrador?</td>
                                        <td>
                                            <select name="admin" class="form-control" required>
                                                <option value="0" <?php echo ($usuario->is_admin == 0) ? 'selected' : '';?>>Não</option>
                                                <option value="1" <?php echo ($usuario->is_admin == 1) ? 'selected' : '';?>>Sim</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cadastrar Authy</td>
                                        <td>
                                            <a href="javascript:void(0);" class="btn btn-info gerarCadastroAuthy" data-id="<?php echo $usuario->id;?>"><i class="fa fa-plus"></i> Gerar cadastro Authy para essa conta</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Páginas/Blocos Bloqueadas(os)</td>
                                        <td>
                                            <select name="permissoes_blocks[]" class="page_blocks" multiple>
                                            <?php
                                            
                                            foreach(TiposPermissao() as $indexG=>$grupo){

                                                echo '<optgroup label="'.$indexG.'">';
                                                foreach($grupo as $page=>$namePage){

                                                    $selected = (in_array($page, $allPermission)) ? 'selected' : '';

                                                    echo '<option value="'.$page.'" '.$selected.'>'.$namePage.'</option>';
                                                }
                                                echo '</optgroup>';
                                            }
                                            ?>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                            <button type="submit" name="submitAdmin" value="Atualizar" class="btn btn-success btn-block">Atualizar Configurações</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

<!-- Adicionar Extrato -->
<div class="modal fade add-extrato" tabindex="-1" role="dialog" aria-labelledby="addExtratoTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="addExtratoTitle">Adicionar Registro no Extrato</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <div class="fill_form">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <td>Descrição</td>
                                <td><textarea class="form-control" name="edit_descricao" cols="47" rows="7"></textarea></td>
                            </tr>
                            <tr>
                                <td>Valor</td>
                                <td><input type="text" class="form-control" name="edit_valor" data-plugin="moneymask" /></td>
                            </tr>
                            <tr>
                                <td>Tipo de Saldo</td>
                                <td>
                                    <select name="edit_tipo_saldo" class="form-control">
                                        <?php
                                        foreach($tipos_disponiveis as $idTipo=>$tipo){
                                        ?>
                                        <option value="<?php echo $idTipo;?>"><?php echo $tipo;?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Categoria</td>
                                <td>
                                    <select name="edit_categoria" class="form-control">
                                        <?php
                                        foreach($categorias_disponiveis as $idCategoria=>$categoria){
                                        ?>
                                        <option value="<?php echo $idCategoria;?>"><?php echo $categoria;?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Ref.</td>
                                <td><input type="text" name="edit_referencia" class="form-control" /></td>
                            </tr>
                            <tr>
                                <td>Liberado</td>
                                <td>
                                    <select name="edit_liberado" class="form-control">
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Data da Criação</td>
                                <td><input type="datetime-local" name="edit_data_criacao" class="form-control" /></td>
                            </tr>
                        </table>
                    </div>
                    <input type="hidden" name="id_record_extract" />
                    <button class="btn btn-success btn-block saveRecordExtract">Adicionar Registro</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Editar EExtrato -->
<div class="modal fade editar-extrato" tabindex="-1" role="dialog" aria-labelledby="editExtratoTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="editExtratoTitle">Editar Extrato</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <div class="load_info_edit" style="display:none;">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <td>Descrição</td>
                                <td><textarea class="form-control" name="descricao" cols="47" rows="7"></textarea></td>
                            </tr>
                            <tr>
                                <td>Valor</td>
                                <td><input type="text" class="form-control" name="valor" data-plugin="moneymask" /></td>
                            </tr>
                            <tr>
                                <td>Tipo de Saldo</td>
                                <td>
                                    <select name="tipo_saldo" class="form-control">
                                        <?php
                                        foreach($tipos_disponiveis as $idTipo=>$tipo){
                                        ?>
                                        <option value="<?php echo $idTipo;?>"><?php echo $tipo;?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Categoria</td>
                                <td>
                                    <select name="categoria" class="form-control">
                                        <?php
                                        foreach($categorias_disponiveis as $idCategoria=>$categoria){
                                        ?>
                                        <option value="<?php echo $idCategoria;?>"><?php echo $categoria;?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Ref.</td>
                                <td><input type="text" name="referencia" class="form-control" /></td>
                            </tr>
                            <tr>
                                <td>Liberado</td>
                                <td>
                                    <select name="liberado" class="form-control">
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Data da Criação</td>
                                <td><input type="datetime-local" name="data_criacao" class="form-control" /></td>
                            </tr>
                        </table>
                    </div>
                    <input type="hidden" name="id_record_extract" />
                    <button class="btn btn-success btn-block saveChangesExtract">Salvar Alterações</button>
                </div>
                <div class="pre_loading" align="center">
                    <i class="fa fa-spinner fa-pulse fa-3x"></i>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Editar Fatura -->
<div class="modal fade editar-fatura" tabindex="-1" role="dialog" aria-labelledby="editFaturaTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="editFaturaTitle">Editar Fatura</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <div class="load_info_edit_fatura" style="display:none;">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <td>Plano</td>
                                <td>
                                    <select name="fatura_edit_plano" class="form-control">
                                        <?php
                                        foreach($planos as $plano){
                                        ?>
                                        <option value="<?php echo $plano->id;?>"><?php echo $plano->nome;?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>Valor</td>
                                <td><input type="text" class="form-control" name="fatura_edit_valor" data-plugin="moneymask" /></td>
                            </tr>

                            <tr>
                                <td>Paga final de semana</td>
                                <td>
                                    <select name="fatura_edit_fds" class="form-control">
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>Porcentagem</td>
                                <td><input type="text" class="form-control" name="fatura_edit_porcentagem" data-plugin="moneymask" /></td>
                            </tr>

                            <tr>
                                <td>Dias pagos</td>
                                <td><input type="number" class="form-control" name="fatura_edit_dias_pagos" /></td>
                            </tr>

                            <tr>
                                <td>Total de dias</td>
                                <td><input type="number" class="form-control" name="fatura_edit_dias_totais" /></td>
                            </tr>

                            <tr>
                                <td>Valor liberado para saque</td>
                                <td><input type="text" class="form-control" name="fatura_edit_liberado" data-plugin="moneymask" /></td>
                            </tr>

                            <tr>
                                <td>Plano Cortesia</td>
                                <td>
                                    <select name="fatura_edit_cortesia" class="form-control">
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>Meio de Pagamento</td>
                                <td><input type="text" class="form-control" name="fatura_edit_meio" /></td>
                            </tr>

                            <tr>
                                <td>Detalhes interno do pagamento</td>
                                <td><input type="text" class="form-control" name="fatura_edit_detalhes_interno" /></td>
                            </tr>

                            <tr>
                                <td>Status</td>
                                <td>
                                    <select name="fatura_edit_status" class="form-control">
                                        <option value="0">Pendente</option>
                                        <option value="1">Pago</option>
                                        <option value="2">Expirado</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>Raiz Paga</td>
                                <td>
                                    <select name="fatura_edit_raiz_paga" class="form-control">
                                        <option value="0">Não</option>
                                        <option value="1">Sim</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>Gerado em</td>
                                <td><input type="datetime-local" name="fatura_edit_gerada" class="form-control" /></td>
                            </tr>

                            <tr>
                                <td>Pago em</td>
                                <td><input type="datetime-local" name="fatura_edit_pago_em" class="form-control" /></td>
                            </tr>

                            <tr>
                                <td>Primeiro Recebimento</td>
                                <td><input type="date" name="fatura_edit_recebimento" class="form-control" /></td>
                            </tr>

                            <tr>
                                <td>Último Pagamento</td>
                                <td><input type="datetime-local" name="fatura_edit_ultimo_pagamento" class="form-control" /></td>
                            </tr>

                            <tr>
                                <td>Expirado em</td>
                                <td><input type="datetime-local" name="fatura_edit_expirado" class="form-control" /></td>
                            </tr>

                        </table>
                    </div>
                    <input type="hidden" name="id_record_fatura" />
                    <button class="btn btn-success btn-block saveChangesFatura">Salvar Alterações</button>
                </div>
                <div class="pre_loading_fatura" align="center">
                    <i class="fa fa-spinner fa-pulse fa-3x"></i>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->