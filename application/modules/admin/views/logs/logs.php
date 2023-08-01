<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Logs dos administradores</h4>
                <p class="card-title-desc">Todos os logs referentes a todos os logins administrativos do sistema.</p>

                <div>
                    <div class="table-responsive">
                        <?php
                        if($logs !== false){
                        ?>
                        <table id="" class="table table-striped simpletable_order_by_0_desc">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Login</th>
                                <th>Log</th>
                                <th>IP</th>
                                <th>Data</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($logs as $log){
                                
                            ?>
                            <tr>
                                <th><?php echo $log->id;?></th>
                                <td><?php echo $log->login;?></td>
                                <td><?php echo $log->log;?></td>
                                <td><a href="https://tools.keycdn.com/geo?host=<?php echo $log->ip;?>" target="_blank"><?php echo $log->ip;?></a></td>
                                <td><?php echo date('d/m/Y H:i:s', strtotime($log->data_criacao));?></td>
                               
                            </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                        }else{
                            echo alerts('Não há nenhum log encontrado.', 'info');
                        }
                        ?>
                    </div>

                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->