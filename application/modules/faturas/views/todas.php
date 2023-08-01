<div class="pcoded-content">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $nome_pagina;?></h5>
        </div>
        <div class="card-body table-border-style">

            <?php
            if($this->session->flashdata('message_faturas')){
                echo $this->session->flashdata('message_faturas');
            }
            ?>

            <div class="table-responsive dt-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo $this->lang->line('fat_form_id');?></th>
                            <th><?php echo $this->lang->line('fat_form_plano');?></th>
                            <th><?php echo $this->lang->line('fat_form_valor');?></th>
                            <th><?php echo $this->lang->line('fat_form_criacao');?></th>
                            <th><?php echo $this->lang->line('fat_form_acao');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($faturas !== false){
                            foreach($faturas as $fatura){
                        ?>
                        <tr>
                            <td><?php echo $fatura->id;?></td>
                            <td class="text-uppercase"><?php echo $fatura->nome;?></td>
                            <td><?php echo MOEDA;?> <?php echo number_format($fatura->valor, 2, ',', '.');?></td>
                            <td><?php echo date('d/m/Y H:i:s', strtotime($fatura->data_criacao));?></td>
                            <td>
                                <?php
                                $rotaPagamento = str_replace(array('(:num)', '(:any)'), array($fatura->id, $fatura->id), $rotas->faturas_pagamento);
                                $rotaExcluirFatura = str_replace(array('(:num)', '(:any)'), array($fatura->id, $fatura->id), $rotas->faturas_excluir);
                                ?>
                                <a href="<?php echo base_url($rotaPagamento);?>" class="btn btn-sm btn-secondary"> <?php echo $this->lang->line('fat_form_button_pagamento');?></a>
                                <a href="<?php echo base_url($rotaExcluirFatura);?>" class="btn btn-sm btn-danger"> <small class="fa fa-trash"></small> <?php echo $this->lang->line('fat_form_button_excluir');?></a>
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