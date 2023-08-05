<div class="pcoded-content">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('con_pix_titulo'); ?></h5>
        </div>
        <div class="card-body">

            <?php if (isset($message)) echo $message; ?>

            <form action="" method="post">

                <div class="form-group">
                    <label>NOMBRE</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo (isset($pix['nombre'])) ? $pix['nombre'] : ''; ?>" placeholder="<?php echo $this->lang->line('dni'); ?>" required>
                </div>
                <div class="form-group">
                    <label>DNI</label>
                    <input type="text" class="form-control" name="dni" value="<?php echo (isset($pix['dni'])) ? $pix['dni'] : ''; ?>" placeholder="<?php echo $this->lang->line('dni'); ?>" required>
                </div>

                <div class="form-group">
                    <label>CUENTA</label>
                    <input type="text" class="form-control" name="cuenta" value="<?php echo (isset($pix['cuenta'])) ? $pix['cuenta'] : ''; ?>" placeholder="<?php echo $this->lang->line('dni'); ?>" required>
                </div>
                <div class="form-group">
                    <label>CCI</label>
                    <input type="text" class="form-control" name="cci" value="<?php echo (isset($pix['cci'])) ? $pix['cci'] : ''; ?>" placeholder="<?php echo $this->lang->line('dni'); ?>" required>
                </div>





                <button type="submit" name="submit" value="Atualizar" class="btn btn-secondary"><?php echo $this->lang->line('con_pix_button'); ?></button>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            </form>
        </div>
    </div>
</div>