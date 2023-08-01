<div class="pcoded-content">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $nome_pagina;?></h5>
        </div>
        <div class="card-body table-border-style">
            <div class="table-responsive dt-responsive">
                <table class="table simpletable">
                    <thead>
                        <tr>
                            <th><?php echo $this->lang->line('ind_pendentes_form_nome');?></th>
                            <th><?php echo $this->lang->line('ind_pendentes_form_celular');?></th>
                            <th><?php echo $this->lang->line('ind_pendentes_form_data_cadastro');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($indicados !== false){
                            foreach($indicados as $indicado){
                        ?>
                        <tr>
                            <td><?php echo $indicado->nome;?></td>
                            <td><?php echo $indicado->celular;?></td>
                            <td><?php echo date('d/m/Y H:i:s', strtotime($indicado->data_cadastro));?></td>
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