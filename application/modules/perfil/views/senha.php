<div class="pcoded-content">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $nome_pagina;?></h5>
        </div>
        <div class="card-body">

            <?php if(isset($message)) echo $message; ?>

            <form action="" method="post">
                <div class="form-group">
                    <label><?php echo $this->lang->line('perf_senha_senha_atual');?></label>
                    <input type="password" class="form-control" name="senha_atual" placeholder="<?php echo $this->lang->line('perf_senha_senha_atual');?>" required>
                </div>
                <div class="form-group">
                    <label><?php echo $this->lang->line('perf_senha_nova_senha');?></label>
                    <input type="password" class="form-control" name="senha_nova" placeholder="<?php echo $this->lang->line('perf_senha_nova_senha');?>" required>
                </div>
                <div class="form-group">
                    <label><?php echo $this->lang->line('perf_senha_confirmar_nova_senha');?></label>
                    <input type="text" class="form-control" name="senha_confirmar" placeholder="<?php echo $this->lang->line('perf_senha_confirmar_nova_senha');?>" required>
                </div>
                <button type="submit" name="submit" value="Atualizar" class="btn btn-secondary btn-block"><?php echo $this->lang->line('perf_senha_alterar_senha_button');?></button>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
            </form>
        </div>
    </div>
</div>