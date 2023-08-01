<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Visão Geral - <?php echo $nome_pagina;?></h4>
                <p class="card-title-desc">Encontre abaixo uma tabela com a <?php echo $nome_pagina;?></p>

                <div>
                
                    <div class="table-responsive">
                        <?php
                        if($pesquisas !== false){
                        ?>
                        <table id="" class="table table-striped simpletable">
                            <thead>
                            <tr>
                                <th>Usuário</th>
                                <th>Patrocinador</th>
                                <th>Entrou em contato</th>
                                <th>Precisa de ajuda</th>
                                <th>Sabe investir</th>
                                <th>Nota</th>
                                <th>Comentário</th>
                                <th>Data do Envio</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($pesquisas as $pesquisa){
                            ?>
                            <tr>
                                <td><?php echo UserInfo('login', $pesquisa->id_usuario);?></td>
                                <td><?php echo $pesquisa->login;?></td>
                                <td><?php echo ($pesquisa->contato == 1) ? 'Sim' : 'Não';?></td>
                                <td><?php echo ($pesquisa->ajuda == 1) ? 'Sim' : 'Não';?></td>
                                <td><?php echo ($pesquisa->investir == 1) ? 'Sim' : 'Não';?></td>
                                <td><?php echo $pesquisa->nota;?></td>
                                <td><?php echo $pesquisa->comentario;?></td>
                                <td><?php echo date('d/m/Y H:i:s', strtotime($pesquisa->data_criacao));?></tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                        }else{
                            echo alerts('Não há pesquisa de satisfação de patrocinador no momento.', 'info');
                        }
                        ?>
                    </div>

                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->