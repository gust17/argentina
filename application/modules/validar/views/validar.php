<div class="pcoded-content">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $nome_pagina;?></h5>
        </div>
        <div class="card-body">

            <?php
            if(UserInfo('cadastro_validado') == 0){

                if($status['status'] == 3 || $status['status'] == 2){

                    if($status['status'] == 2){
                        echo alerts('Infelizmente os seus documentos enviados foram rejeitados, veja o motivo: '.$status['mensagem'], 'danger');
                    }
            ?>

            <p>Para validar sua conta, veja as regras que devem ser cumpridas para seu documento não ser rejeitado:</p>
            <ul>
                <li>Documento em bom estado;</li>
                <li>Foto da frente e verso mostrando a fotografia;</li>
                <li>Selfie segurando o documento aparecendo rosto e documento completo;</li>
                <li>Formatos aceitos: JPEG, JPG, PNG e PDF;</li>
                <li>Fotos não nítidas serão rejeitadas;</li>
                <li>Fotos borradas serão rejeitadas;</li>
                <li>Dica: Tire as fotos em lugares claros.</li>
            </ul>

            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Frente do documento</label>
                    <input type="file" class="form-control" name="foto_frente" required>
                </div>
                <div class="form-group">
                    <label>Verso do documento</label>
                    <input type="file" class="form-control" name="foto_verso" required>
                </div>
                <div class="form-group">
                    <label>Selfie segurando o documento</label>
                    <input type="file" class="form-control" name="foto_seflie" required>
                </div>
                <button type="submit" name="submit" value="enviar" load-button="on" load-text="Enviando Documentos..." class="btn btn-secondary btn-block">Enviar documentos</button>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
            </form>
            <?php
                }elseif($status['status'] == 0){

                    if(!isset($message)){
                        echo alerts('Seus documentos ainda estão em verificação. Em breve você receberá uma notificação em seu backoffice sobre a verificação de seu documento.', 'info');
                    }else{
                        echo $message;
                    }
                }
            }else{
                echo alerts('O seu cadastro já está validado. Você não precisa enviar mais nenhum documento.', 'warning');
            }
            ?>
        </div>
    </div>
</div>