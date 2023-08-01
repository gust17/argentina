<div class="pcoded-content">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $nome_pagina;?></h5>
        </div>
        <div class="card-body table-border-style">
            <div class="table-responsive dt-responsive">
                <table class="table simpletable_d_order_by_0_desc">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo $this->lang->line('ext_form_descricao');?></th>
                            <th><?php echo $this->lang->line('ext_form_valor');?></th>
                            <th><?php echo $this->lang->line('ext_form_tipo');?></th>
                            <th><?php echo $this->lang->line('ext_form_saldo');?></th>
                            <th><?php echo $this->lang->line('ext_form_data');?></th>
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
                            <td><span class="badge badge-light-<?php echo ($transacao->tipo_saldo == 1) ? 'success' : 'danger';?> badge-pill"><?php echo TipoExtrato($transacao->tipo_saldo);?></span></td>
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
    </div>
</div>