<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Grupos de Afiliados</h4>
                <p class="card-title-desc">Redirecione os afiliados a grupos de whatsapp, telegram, etc.</p>

                <div class="mt-4">
                    <div class="table-responsive">
                        
                        <?php if(isset($message)) echo $message;?>
                        
                        <form action="" method="post">
                        <button type="button" class="btn btn-info btn-block mb-3 addGrupos"><i class="fa fa-plus"></i> Adicionar mais grupos</button>
                            <table id="" class="table table-striped">
                                <body>
                                    <tr>
                                        <td>Grupos</td>
                                        <td>
                                            <?php
                                            if(!empty($grupos)){

                                                echo '<div class="grupoDB">';

                                                foreach($grupos as $tituloGrupo=>$linkGrupo){
                                            ?>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <input type="text" name="grupo_name[]" class="form-control" placeholder="Título no menu" value="<?php echo $tituloGrupo;?>" />
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" name="grupo_link[]" class="form-control" placeholder="Link do Grupo" value="<?php echo $linkGrupo;?>" />
                                                </div>
                                            </div>
                                            <?php
                                                }

                                                echo '</div>';
                                            }
                                            ?>
                                            <div class="grupoHTMLForm">
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <input type="text" name="grupo_name[]" class="form-control" placeholder="Título no menu" />
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="grupo_link[]" class="form-control" placeholder="Link do Grupo" />
                                                    </div>
                                                </div>
                                            </div>
                                            

                                            <button type="submit" name="submit" value="Atualizar" class="btn btn-success btn-block">Salvar Grupos</button>
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                        </td>
                                    </tr>
                                </body>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->