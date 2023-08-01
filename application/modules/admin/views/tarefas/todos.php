<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Visão Geral - <?php echo $nome_pagina;?></h4>
                <p class="card-title-desc">Encontre abaixo uma tabela com a <?php echo $nome_pagina;?></p>

                <div>
                
                    <?php if($this->session->flashdata('tarefas_messages')) echo $this->session->flashdata('tarefas_messages'); ?>
                
                    <div class="table-responsive">
                        <?php
                        if($tarefas !== false){
                        ?>
                        <table id="" class="table table-striped simpletable">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Login</th>
                                <th>Tarefa</th>
                                <th>Print</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($tarefas as $tarefa){

                                $rotaAprovar = str_replace(array('(:num)', '(:any)'), array($tarefa->id, $tarefa->id), $rotas->admin_tarefas_aprovar);
                                $rotaRejeitar = str_replace(array('(:num)', '(:any)'), array($tarefa->id, $tarefa->id), $rotas->admin_tarefas_rejeitar);
                                
                            ?>
                            <tr>
                                <th><?php echo UserInfo('nome', $tarefa->id_usuario);?></th>
                                <th><?php echo UserInfo('login', $tarefa->id_usuario);?></th>
                                <th><?php echo $tarefa->tarefa;?></th>
                                <td>
                                    <a href="<?php echo $tarefa->print;?>" target="_blank">Print da Tarefa</a>
                                </td>
                                <td>
                                    <?php
                                    if($tarefa->status == 0){
                                        echo '<span class="badge badge-warning">Pendente</span>';
                                    }elseif($tarefa->status == 1){
                                        echo '<span class="badge badge-success">Aprovado</span>';
                                    }else{
                                        echo '<span class="badge badge-danger">Rejeitado</span>';
                                    }
                                    ?>
                                <td>
                                    <?php
                                    if($tarefa->status == 0){
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
                            echo alerts('Não há nenhum print de tarefa enviado até o momento.', 'info');
                        }
                        ?>
                    </div>

                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->