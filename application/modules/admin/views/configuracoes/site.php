<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Editar Configurações do site</h4>
                <p class="card-title-desc">Editar todas as configurações do site.</p>

                <div class="mt-4">
                    <div class="table-responsive">
                        
                        <?php if(isset($message)) echo $message;?>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#geral" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Geral</span> 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#logo" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Logos</span> 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#smtp" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">SMTP</span> 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#servidor" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Servidor</span> 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#cancelamento" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">Cancelamento de Contrato</span> 
                                </a>
                            </li>
                        </ul>
                        
                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="geral" role="tabpanel">
                                <form action="" method="post">
                                    <table id="" class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <td>Nome do site</td>
                                                <td><input type="text" name="nome_site" class="form-control" placeholder="Nome do site" value="<?php echo SystemInfo('nome_site');?>" required /></td>
                                            </tr>
                                            <tr>
                                                <td>Descrição do site</td>
                                                <td><textarea cols="45" rows="7" class="form-control" name="descricao_site"><?php echo SystemInfo('descricao_site');?></textarea></td>
                                            </tr>
                                            <tr>
                                                <td>Google Analytics</td>
                                                <td><textarea cols="45" rows="7" class="form-control" name="google_analytics"><?php echo SystemInfo('google_analytics');?></textarea></td>
                                            </tr>
                                            <tr>
                                                <td>Modal Backoffice</td>
                                                <td>
                                                    <input type="radio" name="modal_backoffice_status" value="1" <?php echo ($modal_backoffice_status == 1) ? 'checked' :  '';?> /> Habilitado
                                                    <input type="radio" name="modal_backoffice_status" value="0" <?php echo ($modal_backoffice_status == 0) ? 'checked' :  '';?> /> Desabilitado

                                                    <textarea name="modal_backoffice_editor" class="modal_backoffice_editor"><?php echo SystemInfo('modal_backoffice_editor');?></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>QueryString da URL do Patrocinador</td>
                                                <td><input type="text" name="query_string_patrocinador" class="form-control" placeholder="QueryString" value="<?php echo SystemInfo('query_string_patrocinador');?>" required /></td>
                                            </tr>
                                            <tr>
                                                <td>Código do Patrocinador Padrão</td>
                                                <td><input type="text" name="codigo_patrocinio_padrao" class="form-control" placeholder="Código de indicação do patrocinador padrão" value="<?php echo SystemInfo('codigo_patrocinio_padrao');?>" required /></td>
                                            </tr>
                                            <tr>
                                                <td>Quantidade máxima de compras de pacotes por conta</td>
                                                <td>
                                                    <input type="number" name="quantidade_planos" class="form-control" placeholder="Máximo de compras de planos no sistema" value="<?php echo SystemInfo('quantidade_planos');?>" required />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Níveis do unilevel</td>
                                                <td><input type="number" name="niveis_unilevel" class="form-control" placeholder="Máximo de níveis do unilevel" value="<?php echo SystemInfo('niveis_unilevel');?>" /></td>
                                            </tr>
                                            <tr>
                                                <td>Identificação de Faturas Cortesias</td>
                                                <td><input type="text" name="faturas_cortesia_label" class="form-control" placeholder="Identificação das faturas cortesias" value="<?php echo SystemInfo('faturas_cortesia_label');?>" required /></td>
                                            </tr>
                                            <tr>
                                                <td>Formato da moeda no sistema</td>
                                                <td><input type="text" name="moeda_formato" class="form-control" placeholder="Formato da moeda no sistema" value="<?php echo SystemInfo('moeda_formato');?>" required /></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <button type="submit" name="submit" value="Atualizar" class="btn btn-success btn-block">Atualizar Configurações do site</button>
                                                    <input type="hidden" name="<?php echo $csrf_name;?>" value="<?php echo $csrf_token;?>" />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>

                            <div class="tab-pane" id="logo" role="tabpanel">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <table id="" class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <td>Logo Desktop</td>
                                                <td><input type="file" name="logo_desktop" class="form-control" /></td>
                                            </tr>
                                            <tr>
                                                <td>Logo Mobile</td>
                                                <td><input type="file" name="logo_mobile" class="form-control" /></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <button type="submit" name="submit3" value="Atualizar" class="btn btn-success btn-block">Atualizar Logos</button>
                                                    <input type="hidden" name="<?php echo $csrf_name;?>" value="<?php echo $csrf_token;?>" />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>

                            <div class="tab-pane" id="smtp" role="tabpanel">
                                <form action="" method="post">
                                    <table id="" class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <td>SMTP Host</td>
                                                <td><input type="text" name="smtp_host" class="form-control" placeholder="Host do SMTP" value="<?php echo SystemInfo('smtp_host');?>" required /></td>
                                            </tr>
                                            <tr>
                                                <td>SMTP Usuário</td>
                                                <td><input type="text" name="smtp_usuario" class="form-control" placeholder="Usuário do SMTP" value="<?php echo SystemInfo('smtp_usuario');?>" required /></td>
                                            </tr>
                                            <tr>
                                                <td>SMTP Senha</td>
                                                <td><input type="text" name="smtp_senha" class="form-control" placeholder="Senha do SMTP" value="<?php echo SystemInfo('smtp_senha');?>" required /></td>
                                            </tr>
                                            <tr>
                                                <td>SMTP Port</td>
                                                <td><input type="text" name="smtp_port" class="form-control" placeholder="Porta do SMTP" value="<?php echo SystemInfo('smtp_port');?>" required /></td>
                                            </tr>
                                            <tr>
                                                <td>SMTP Encrypt</td>
                                                <td>
                                                <select name="smtp_encrypt" class="form-control">
                                                <?php
                                                $smtp_encrypt = SystemInfo('smtp_encrypt');
                                                foreach(CategoriasEncryptSMTP() as $keyEncrypt=>$valueEncrypt){

                                                    $selected = ($smtp_encrypt == $keyEncrypt) ? 'selected' : '';

                                                    echo '<option value="'.$keyEncrypt.'" '.$selected.'>'.$valueEncrypt.'</option>';
                                                }
                                                ?>
                                                </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <button type="submit" name="submit4" value="Atualizar" class="btn btn-success btn-block">Atualizar SMTP</button>
                                                    <input type="hidden" name="<?php echo $csrf_name;?>" value="<?php echo $csrf_token;?>" />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>

                            <div class="tab-pane" id="cancelamento" role="tabpanel">
                                <form action="" method="post">
                                    <table id="" class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <td>Habilitar Cancelamento</td>
                                                <td>
                                                    <input type="radio" name="habilitar_cancelamento" value="1" <?php echo ($habilitar_cancelamento == 1) ? 'checked' : '';?>> Sim <br />
                                                    <input type="radio" name="habilitar_cancelamento" value="0" <?php echo ($habilitar_cancelamento == 0) ? 'checked' : '';?>> Não <br />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Taxa de Cancelamento</td>
                                                <td><input type="number" name="taxa_cancelamento" class="form-control" placeholder="Taxa de Cancelamento" value="<?php echo SystemInfo('taxa_cancelamento');?>" /></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <button type="submit" name="submit2" value="Atualizar" class="btn btn-success btn-block">Atualizar Cancelamento de Contrato</button>
                                                    <input type="hidden" name="<?php echo $csrf_name;?>" value="<?php echo $csrf_token;?>" />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>

                            <div class="tab-pane" id="servidor" role="tabpanel">
                                <form action="" method="post">
                                    <table id="" class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <td>IP do Servidor</td>
                                                <td><input type="text" name="ip_servidor" class="form-control" placeholder="IP do Servidor" value="<?php echo SystemInfo('ip_servidor');?>" required /></td>
                                            </tr>
                                            <tr>
                                                <td>Hora do Rendimento</td>
                                                <td><input type="time" name="rendimento_hora" class="form-control" placeholder="Hora do rendimento" value="<?php echo SystemInfo('rendimento_hora');?>" /></td>
                                            </tr>
                                            <tr>
                                                <td>Site em Manutenção?</td>
                                                <td>
                                                <select name="manutencao" class="form-control">
                                                <?php
                                                $manutencao = SystemInfo('manutencao');
                                                ?>
                                                <option value="1" <?php echo ($manutencao == 1) ? 'selected' : '';?>>Sim</option>
                                                <option value="0" <?php echo ($manutencao == 0) ? 'selected' : '';?>>Não</option>
                                                </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Logins liberados da manutenção</td>
                                                <td>
                                                <select name="contas_liberadas[]" class="form-control cadastros_liberados_manutencao" multiple="multiple" style="min-width:300px;">
                                                <?php
                                                $contas_liberadas = json_decode(SystemInfo('contas_liberadas'), true);
                                                foreach($usuarios as $usuario){
                                                ?>
                                                <option value="<?php echo $usuario->id;?>" <?php echo (in_array($usuario->id, $contas_liberadas)) ? 'selected' : '';?>><?php echo $usuario->login;?></option>
                                                <?php
                                                }
                                                ?>
                                                </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <button type="submit" name="submit5" value="Atualizar" class="btn btn-success btn-block">Atualizar dados do servidor</button>
                                                    <input type="hidden" name="<?php echo $csrf_name;?>" value="<?php echo $csrf_token;?>" />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div> <!-- tab-content -->
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->