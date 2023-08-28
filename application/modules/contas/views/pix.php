<div class="pcoded-content">
    <div class="card">
        <div class="card-header">
            <h5>Billetera USDT</h5>
        </div>
        <div class="card-body">

            <?php if (isset($message)) echo $message; ?>

            <form action="" method="post">

                <div class="form-group">
                    <label>Billetera</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo (isset($pix['carteiraUsdt'])) ? $pix['carteiraUsdt'] : ''; ?>" placeholder="Billera USDT" required>
                </div>






                <button type="submit" name="submit" value="Atualizar" class="btn btn-secondary"><?php echo $this->lang->line('con_pix_button'); ?></button>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            </form>
        </div>
    </div>
</div>