<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Editar Chave Pix</h4>
                <p class="card-title-desc">Editar a Chave Pix de recebimento</p>

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
                                <a class="nav-link" data-toggle="tab" href="#gerencianet" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Gerencianet</span> 
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
                                                <td>Habilitar Pix?</td>
                                                <td>
                                                <select name="habilitar_pix" class="form-control">
                                                <?php
                                                $habilitado = SystemInfo('habilitar_pix');
                                                ?>
                                                <option value="1" <?php echo ($habilitado == 1) ? 'selected' : '';?>>Sim</option>
                                                <option value="0" <?php echo ($habilitado == 0) ? 'selected' : '';?>>Não</option>
                                                </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Chave Pix</td>
                                                <td><input type="text" name="pix" class="form-control" placeholder="Chave Pix" value="<?php echo SystemInfo('chave_pix');?>" required /></td>
                                            </tr>
                                            <tr>
                                                <td>Tipo do Pix</td>
                                                <td>
                                                <select name="tipo_pix" class="form-control">
                                                <?php
                                                $tipoPix = SystemInfo('tipo_pix');
                                                ?>
                                                <option value="1" <?php echo ($tipoPix == 1) ? 'selected' : '';?>>Automático</option>
                                                <option value="2" <?php echo ($tipoPix == 2) ? 'selected' : '';?>>Manual</option>
                                                </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <button type="submit" name="submit" value="Atualizar" class="btn btn-success btn-block">Atualizar Dados</button>
                                                    <input type="hidden" name="<?php echo $csrf_name;?>" value="<?php echo $csrf_token;?>" />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>

                            <div class="tab-pane" id="gerencianet" role="tabpanel">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <table id="" class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <td>ClientID</td>
                                                <td><input type="text" name="cliente_id" class="form-control" value="<?php echo SystemInfo('gerencianet_client_id');?>" required /></td>
                                            </tr>
                                            <tr>
                                                <td>Client Secret</td>
                                                <td><input type="text" name="cliente_secret" class="form-control" value="<?php echo SystemInfo('gerencianet_client_secret');?>" required /></td>
                                            </tr>
                                            <tr>
                                                <td>Certificado .PEM</td>
                                                <td><input type="file" name="certificado" class="form-control" accept=".pem" /></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <button type="submit" name="submit2" value="Atualizar" class="btn btn-success btn-block">Atualizar dados do Gerencianet</button>
                                                    <input type="hidden" name="<?php echo $csrf_name;?>" value="<?php echo $csrf_token;?>" />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->