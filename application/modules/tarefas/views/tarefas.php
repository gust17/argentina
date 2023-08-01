<div class="pcoded-content">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $nome_pagina;?></h5>
        </div>
        <div class="card-body table-border-style">

            <p>Você pode alavancar seu score ainda mais completando tarefas em nosso sistema. Funciona assim:</p>

            <ul>
                <li>Escolha uma ou mais tarefas abaixo para realizar para alavancar seu score;</li>
                <li>Após realizar, tire um print da sua tela para comprovar a conclusão da tarefa;</li>
                <li>Envie o print da tarefa no campo respectivo da tarefa abaixo e clique em "Enviar print";</li>
                <li>Pronto, agora aguarde que em até 12h nossa equipe irá verificar e aprovar a tarefa. Caso seu print não seja aceito, você receberá uma mensagem informando o motivo.</li>
            </ul>

            <p>Tire um print completo da sua tela para facilitar a identificação da conclusão da  tarefa.</p>

            <?php
            if(isset($message)) echo $message;
            ?>

            <div class="table-responsive dt-responsive">
                <table class="table simpletable">
                    <thead>
                        <tr>
                            <th>Tarefa</th>
                            <th>Recompensa</th>
                            <th>Status</th>
                            <th>Anexar Print</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($tarefas !== false){
                            foreach($tarefas as $tarefa){

                                $status = $this->TarefasModel->StatusEntregaTarefa($tarefa->id);
                        ?>
                        <tr>
                            <td><?php echo $tarefa->tarefa;?></td>
                            <td>+ <?php echo $tarefa->recompensa;?> pontos no score</td>
                            <td>
                                <?php
                                if($status == 0){
                                    echo '<span class="badge badge-primary">Não enviado</span>';
                                }elseif($status == 1){
                                    echo '<span class="badge badge-warning">Aguardando aprovação</span>';
                                }elseif($status == 2){
                                    echo '<span class="badge badge-success">Aprovado</span>';
                                }else{
                                    echo '<span class="badge badge-danger">Reprovado, envie novamente</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if($tarefa->data_liberacao <= date('Y-m-d')){

                                    if($status == 0 || $status == 3){
                                ?>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <input type="file" name="anexo" id="anexo" class="form-control m-b-10" required>
                                    <button type="submit" name="submit" value="submit" class="btn btn-secondary btn-primary">Enviar print</button>
                                    <input type="hidden" name="id_tarefa" value="<?php echo $tarefa->id;?>">
                                    <input type="hidden" name="<?php echo $csrfName;?>" value="<?php echo $csrfHash;?>" />
                                </form>
                                <?php
                                    }
                                }else{
                                    echo '<span class="badge badge-secondary">Tarefa não liberada (Libera em '.date('d/m/Y', strtotime($tarefa->data_liberacao)).')</span>';
                                }
                                ?>
                            </td>
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