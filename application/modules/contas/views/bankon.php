<div class="pcoded-content">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('con_bankon_titulo');?></h5>
        </div>
        <div class="card-body">

            <?php if(isset($message)) echo $message; ?>

            <form action="" method="post">
                <div class="form-group">
                    <label><?php echo $this->lang->line('con_bankon');?></label>
                    <input type="text" class="form-control" name="bankon" value="<?php echo (isset($bankon['bankon'])) ? $bankon['bankon'] : '';?>" placeholder="<?php echo $this->lang->line('con_bankon_informe');?>" required>
                </div>
                <button type="submit" name="submit" value="Atualizar" class="btn btn-secondary"><?php echo $this->lang->line('con_bankon_button');?></button>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
            </form>
        </div>
    </div>
</div>