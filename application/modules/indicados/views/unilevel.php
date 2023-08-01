<div class="pcoded-content">
    <div class="card">
        <div class="card-body">
            <h5 class="mb-3"><?php echo $nome_pagina;?></h5>
            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                <?php
                for($nivel = 1; $nivel<=$quantidade_niveis; $nivel++){

                    $active = ($nivel == 1) ? 'active' : '';
                ?>
                <li class="nav-item">
                    <a class="nav-link text-uppercase <?php echo $active;?>" id="n<?php echo $nivel;?>-tab" data-toggle="tab" href="#n<?php echo $nivel;?>" role="tab" aria-controls="n<?php echo $nivel;?>" aria-selected="false"><?php echo $nivel;?>º <?php echo $this->lang->line('ind_unilevel_nivel');?></a>
                </li>
                <?php
                }
                ?>
            </ul>
            
            <div class="tab-content" id="myTabContent">
                <?php
                for($nivel = 1; $nivel<=$quantidade_niveis; $nivel++){

                    $active = ($nivel == 1) ? 'active show' : '';
                ?>
                <div class="tab-pane fade <?php echo $active;?>" id="n<?php echo $nivel;?>" role="tabpanel" aria-labelledby="n<?php echo $nivel;?>-tab">
                    <div class="table-responsive dt-responsive">
                        <table class="table simpletable">
                            <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('ind_unilevel_form_nome');?></th>
                                    <th><?php echo $this->lang->line('ind_unilevel_form_celular');?></th>
                                    <th><?php echo $this->lang->line('ind_unilevel_form_cadastro_ativo');?></th>
                                    <th><?php echo $this->lang->line('ind_unilevel_form_data_cadastro');?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(isset($unilevel[$nivel])){
                                    foreach($unilevel[$nivel] as $indicado){
                                ?>
                                <tr>
                                    <td><?php echo $indicado['nome'];?></td>
                                    <td><?php echo $indicado['celular'];?></td>
                                    <td><?php echo ($indicado['ativo'] == 1) ? '<span class="badge badge-success">'.strtoupper($this->lang->line('sim')).'</span>' : '<span class="badge badge-danger">'.strtoupper($this->lang->line('nao')).'</span>';?></td>
                                    <td><?php echo date('d/m/Y H:i:s', strtotime($indicado['data_cadastro']));?></td>
                                </tr>
                                <?php
                                    }
                                }else{
                                    echo '<tr>';
                                    echo '<td colspan="4">'.alerts($this->lang->line('ind_unilevel_nenhum_usuario'), 'secondary').'</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>