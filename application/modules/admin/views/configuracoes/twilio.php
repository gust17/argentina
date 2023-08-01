<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">API Twilio</h4>
                <p class="card-title-desc">Utilize a API do Twilio. Caso você não tenha uma conta, <a href="https://www.twilio.com/" target="_blank">clique aqui</a> para criar uma.</p>

                <div class="mt-4">
                    <div class="table-responsive">
                        
                        <?php if(isset($message)) echo $message;?>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#authy" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Authy</span> 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#sms" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">SMS</span> 
                                </a>
                            </li>
                        </ul>
                        
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="authy" role="tabpanel">
                                <form action="" method="post">
                                    <table id="" class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <td>Habilitar Authy?</td>
                                                <td>
                                                <select name="authy_habilitar" class="form-control">
                                                <?php
                                                $habilitado = SystemInfo('authy_habilitar');
                                                ?>
                                                <option value="1" <?php echo ($habilitado == 1) ? 'selected' : '';?>>Sim</option>
                                                <option value="0" <?php echo ($habilitado == 0) ? 'selected' : '';?>>Não</option>
                                                </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Production API Key</td>
                                                <td><input type="text" name="token" class="form-control" placeholder="API Key" value="<?php echo SystemInfo('authy_token');?>" /></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <button type="submit" name="submit" value="Atualizar" class="btn btn-success btn-block">Atualizar Configurações Authy</button>
                                                    <input type="hidden" name="<?php echo $csrf_name;?>" value="<?php echo $csrf_token;?>" />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                            <div class="tab-pane" id="sms" role="tabpanel">
                                <form action="" method="post">
                                    <table id="" class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <td>Habilitar SMS?</td>
                                                <td>
                                                <select name="sms_habilitar" class="form-control">
                                                <?php
                                                $habilitado = SystemInfo('twilio_sms_habilitar');
                                                ?>
                                                <option value="1" <?php echo ($habilitado == 1) ? 'selected' : '';?>>Sim</option>
                                                <option value="0" <?php echo ($habilitado == 0) ? 'selected' : '';?>>Não</option>
                                                </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>SID</td>
                                                <td><input type="text" name="sid" class="form-control" placeholder="SID" value="<?php echo SystemInfo('twilio_sms_sid');?>" /></td>
                                            </tr>
                                            <tr>
                                                <td>Token</td>
                                                <td><input type="text" name="token" class="form-control" placeholder="Token" value="<?php echo SystemInfo('twilio_sms_token');?>" /></td>
                                            </tr>
                                            <tr>
                                                <td>Service ID</td>
                                                <td><input type="text" name="service_id" class="form-control" placeholder="Service ID" value="<?php echo SystemInfo('twilio_sms_service_id');?>" /></td>
                                            </tr>
                                            <tr>
                                                <td>Quando deve disparar o SMS?</td>
                                                <td>
                                                    <?php
                                                    $pagesTwilioSMS = json_decode(SystemInfo('twilio_sms_paginas'), true);
                                                    foreach(TwilioCategoriasPaginas() as $categoriaTwillioValue=>$categoriaTwillioName){

                                                        $checked = (in_array($categoriaTwillioValue, $pagesTwilioSMS)) ? 'checked' : '';
                                                    ?>
                                                    <input type="checkbox" name="twilio_sms_page[]" value="<?php echo $categoriaTwillioValue;?>" <?php echo $checked;?> /> <?php echo $categoriaTwillioName;?> <br />
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <button type="submit2" name="submit2" value="Atualizar" class="btn btn-success btn-block">Atualizar Configurações de SMS</button>
                                                    <input type="hidden" name="<?php echo $csrf_name;?>" value="<?php echo $csrf_token;?>" />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->