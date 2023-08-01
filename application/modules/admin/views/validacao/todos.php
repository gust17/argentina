<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Visão Geral - <?php echo $nome_pagina;?></h4>
                <p class="card-title-desc">Encontre abaixo uma tabela com a <?php echo $nome_pagina;?></p>

                <div>
                
                    <?php if($this->session->flashdata('documentos_messages')) echo $this->session->flashdata('documentos_messages'); ?>
                
                    <div class="table-responsive">
                        <?php
                        if($documentos !== false){
                        ?>
                        <table id="" class="table table-striped simpletable">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Login</th>
                                <th>Documento</th>
                                <th>Fotos</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($documentos as $documento){

                                $rotaAprovar = str_replace(array('(:num)', '(:any)'), array($documento->id, $documento->id), $rotas->validacao_aprovar);
                                $rotaRejeitar = str_replace(array('(:num)', '(:any)'), array($documento->id, $documento->id), $rotas->validacao_rejeitar);
                                
                            ?>
                            <tr>
                                <th><?php echo UserInfo('nome', $documento->id_usuario);?></th>
                                <th><?php echo UserInfo('login', $documento->id_usuario);?></th>
                                <th><?php echo UserInfo('documento', $documento->id_usuario);?></th>
                                <td>
                                    <a href="<?php echo $documento->foto_frente;?>" target="_blank">FRENTE</a> <br />
                                    <a href="<?php echo $documento->foto_verso;?>" target="_blank">VERSO</a> <br />
                                    <a href="<?php echo $documento->foto_selfie;?>" target="_blank">SELFIE</a>
                                </td>
                                <td>
                                    <?php
                                    if($documento->status == 0){
                                        echo '<span class="badge badge-warning">Pendente</span>';
                                    }elseif($documento->status == 1){
                                        echo '<span class="badge badge-success">Aprovado</span>';
                                    }else{
                                        echo '<span class="badge badge-danger">Rejeitado</span>';
                                    }
                                    ?>
                                <td>
                                    <?php
                                    if($documento->status == 0){
                                    ?>
                                    <a href="<?php echo base_url($rotaAprovar);?>" class="btn btn-success">Aprovar</a>
                                    <a href="<?php echo base_url($rotaRejeitar);?>" class="btn btn-danger rejeitar">Rejeitar</a>
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
                            echo alerts('Não há nenhum documento enviado até o momento.', 'info');
                        }
                        ?>
                    </div>

                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->