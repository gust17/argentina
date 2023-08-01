<div class="pcoded-content">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $nome_pagina;?></h5>
        </div>
        <div class="card-body">

            <?php if(isset($message)) echo $message; ?>

            <?php echo $this->lang->line('perf_meus_dados_obs');?>

            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label><?php echo $this->lang->line('perf_meus_dados_foto');?></label>
                    <input type="file" class="form-control" name="avatar" />
                </div>
                <div class="form-group">
                    <label><?php echo $this->lang->line('c_f_nome');?></label>
                    <input type="text" class="form-control" name="nome" placeholder="<?php echo $this->lang->line('c_f_nome');?>" value="<?php echo $dados->nome;?>" readonly required>
                </div>
                <div class="form-group">
                    <label><?php echo $this->lang->line('c_f_email');?></label>
                    <input type="email" class="form-control" value="<?php echo $dados->email;?>" disabled>
                </div>
                <div class="form-group">
                    <label><?php echo $this->lang->line('perf_meus_dados_data_nascimento');?></label>
                    <input type="text" class="form-control" name="nascimento" value="<?php echo (empty($dados->data_nascimento)) ? '' : date('d/m/Y', strtotime($dados->data_nascimento));?>" readonly placeholder="<?php echo $this->lang->line('perf_meus_dados_data_nascimento');?>">
                </div>
                <div class="form-group">
                    <label><?php echo $this->lang->line('ddi');?></label>
                    <select class="form-control mb-4" name="ddi">
                        <?php
                        foreach($ddis as $ddi){
                            $selected = ($ddi->code == $dados->ddi) ? 'selected' : '';
                            echo '<option value="'.$ddi->code.'" '.$selected.'>'.$ddi->code.' - '.$ddi->name.'</option>';
                        }
                        ?>
                    </select>
                    <label><?php echo $this->lang->line('c_f_celular');?></label>
                    <input type="text" class="form-control" name="celular" value="<?php echo $dados->celular;?>" placeholder="<?php echo $this->lang->line('c_f_celular');?>" required>
                </div>
                <div class="form-group">
                    <label><?php echo $this->lang->line('c_f_documento');?></label>
                    <input type="text" class="form-control" value="<?php echo $dados->documento;?>" disabled>
                </div>
                <div class="form-group">
                    <label><?php echo $this->lang->line('perf_meus_dados_sexo');?></label>
                    <select name="sexo" class="form-control" required>
                        <option value="1" <?php echo ($dados->sexo == 1) ? 'selected' : '';?>><?php echo $this->lang->line('c_f_s_masculino');?></option>
                        <option value="2" <?php echo ($dados->sexo == 2) ? 'selected' : '';?>><?php echo $this->lang->line('c_f_s_feminino');?></option>
                        <option value="3" <?php echo ($dados->sexo == 3) ? 'selected' : '';?>><?php echo $this->lang->line('c_f_s_nao_informar');?></option>
                    </select>
                </div>

                
                <div class="form-group">
                    <label><?php echo $this->lang->line('perf_meus_dados_cep');?></label>
                    <input type="text" class="form-control" name="cep" value="<?php echo $dados->cep;?>" placeholder="<?php echo $this->lang->line('perf_meus_dados_cep');?>">
                </div>
                <div class="form-group">
                    <label><?php echo $this->lang->line('perf_meus_dados_endereco');?></label>
                    <input type="text" class="form-control" name="endereco" value="<?php echo $dados->endereco;?>" placeholder="<?php echo $this->lang->line('perf_meus_dados_endereco');?>">
                </div>
                <div class="form-group">
                    <label><?php echo $this->lang->line('perf_meus_dados_bairro');?></label>
                    <input type="text" class="form-control" name="bairro" value="<?php echo $dados->bairro;?>" placeholder="<?php echo $this->lang->line('perf_meus_dados_bairro');?>">
                </div>
                <div class="form-group">
                    <label><?php echo $this->lang->line('perf_meus_dados_cidade');?></label>
                    <input type="text" class="form-control" name="cidade" value="<?php echo $dados->cidade;?>" placeholder="<?php echo $this->lang->line('perf_meus_dados_cidade');?>">
                </div>
                <div class="form-group">
                    <label><?php echo $this->lang->line('perf_meus_dados_estado');?></label>
                    <input type="text" class="form-control" name="estado" value="<?php echo $dados->estado;?>" placeholder="<?php echo $this->lang->line('perf_meus_dados_estado');?>">
                </div>
                <button type="submit" name="submit" value="Atualizar" class="btn-secondary btn-block"><?php echo $this->lang->line('perf_meus_dados_atualizar_dados_button');?></button>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
            </form>
        </div>
    </div>
</div>

<script>
var tipo_cadastro = '<?php echo UserInfo("tipo_cadastro");?>';
</script>