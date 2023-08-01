<div class="pcoded-content">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $nome_pagina;?></h5>
        </div>
        <div class="card-body table-border-style">
            <div class="table-responsive dt-responsive">
                <table class="table simpletable_order_by_0_desc">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo $this->lang->line('not_form_mensagem');?></th>
                            <th><?php echo $this->lang->line('not_form_data');?></th>
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
    </div>
</div>