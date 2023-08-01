<div class="pcoded-content">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('con_bancaria_titulo');?></h5>
        </div>
        <div class="card-body">

            <?php if(isset($message)) echo $message; ?>

            <form action="" method="post">
                <div class="form-group">
                    <label><?php echo $this->lang->line('con_bancaria_banco');?></label>
                    <select name="banco" class="form-control" required>
                        <?php
                        foreach(ListaBancos() as $codigo=>$banco){

                            $selected = (isset($conta['banco']) && $conta['banco'] == $codigo) ? 'selected' : '';

                            echo '<option value="'.$codigo.'" '.$selected.'>'.$codigo.' - '.$banco.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label><?php echo $this->lang->line('con_bancaria_agencia');?></label>
                    <input type="text" class="form-control" name="agencia" value="<?php echo (isset($conta['agencia'])) ? $conta['agencia'] : '';?>" placeholder="<?php echo $this->lang->line('con_bancaria_agencia');?>" required>
                </div>
                <div class="form-group">
                    <label><?php echo $this->lang->line('con_bancaria_conta');?></label>
                    <input type="text" class="form-control" name="conta" value="<?php echo (isset($conta['conta'])) ? $conta['conta'] : '';?>" placeholder="<?php echo $this->lang->line('con_bancaria_conta');?>" required>
                </div>
                <div class="form-group">
                    <label><?php echo $this->lang->line('con_bancaria_tipo_conta');?></label> <br />
                    <input type="radio" name="tipo" value="1" <?php echo (isset($conta['tipo']) && $conta['tipo'] == 1) ? 'checked' : '';?>> <?php echo $this->lang->line('con_bancaria_conta_corrente');?>
                    <input type="radio" name="tipo" value="2" <?php echo (isset($conta['tipo']) && $conta['tipo'] == 2) ? 'checked' : '';?>> <?php echo $this->lang->line('con_bancaria_conta_poupanca');?>
                </div>
                <div class="form-group">
                    <label><?php echo $this->lang->line('con_bancaria_titularidade');?></label>
                    <input type="text" class="form-control" name="titular" value="<?php echo (isset($conta['titular'])) ? $conta['titular'] : '';?>" placeholder="<?php echo $this->lang->line('con_bancaria_titularidade');?>" required>
                </div>
                <div class="form-group">
                    <label><?php echo $this->lang->line('con_bancaria_documento');?></label>
                    <input type="text" class="form-control" name="documento" value="<?php echo (isset($conta['documento'])) ? $conta['documento'] : '';?>" placeholder="<?php echo $this->lang->line('con_bancaria_documento');?>" required>
                </div>
                <button type="submit" name="submit" value="Atualizar" class="btn btn-secondary btn-block"><?php echo $this->lang->line('con_bancaria_button');?></button>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
            </form>
        </div>
    </div>
</div>