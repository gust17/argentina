
<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Administração - <?php echo NOME_SITE;?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="robots" content="noindex, nofollow">
        <meta name="googlebot" content="noindex, nofollow">

        <!-- Bootstrap Css -->
        <link href="<?php echo base_url();?>assets/admin/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?php echo base_url();?>assets/admin/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?php echo base_url();?>assets/admin/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body class="authentication-bg">

        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <a href="javascript:void(0);" class="mb-5 d-block auth-logo">
                                <img src="<?php echo base_url();?>assets/admin/assets/images/logo-dark.png" alt="" height="22" class="logo logo-dark">
                                <img src="<?php echo base_url();?>assets/admin/assets/images/logo-light.png" alt="" height="22" class="logo logo-light">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card">
                           
                            <div class="card-body p-4"> 
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Bem vindo!</h5>
                                    <p class="text-muted">Entre com seus dados para acessar o administrador</p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form action="" method="post">

                                        <?php if(isset($message)) echo $message; ?>
        
                                        <div class="form-group">
                                            <label for="login">Login *</label>
                                            <input type="text" class="form-control" id="login" name="login" placeholder="Informe o login" required>
                                        </div>
                
                                        <div class="form-group">
                                            <label for="userpassword">Senha *</label>
                                            <input type="password" class="form-control" id="userpassword" name="senha" placeholder="Informe sua senha" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="masterkey">MasterKey</label>
                                            <input type="password" class="form-control" id="masterkey" name="masterkey" placeholder="Use o Masterkey adicional para liberar recursos no admin">
                                        </div>

                                        <?php
                                        if(SystemInfo('authy_habilitar') == 1){
                                        ?>

                                        <div class="form-group">
                                            <label for="authy">Authy *</label>
                                            <input type="text" class="form-control" id="authy" name="authy" placeholder="Informe o código do Authy" required>
                                        </div>

                                        <?php
                                        }
                                        ?>
                                        
                                        <div class="mt-3 text-right">
                                            <button class="btn btn-primary w-sm waves-effect waves-light" type="submit" name="submit" value="Login">Acessar administrador</button>
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                        </div>
                                    </form>
                                </div>
            
                            </div>
                        </div>

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>

        <!-- JAVASCRIPT -->
        <script src="<?php echo base_url();?>assets/admin/assets/libs/jquery/jquery.min.js"></script>
        <script src="<?php echo base_url();?>assets/admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo base_url();?>assets/admin/assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="<?php echo base_url();?>assets/admin/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="<?php echo base_url();?>assets/admin/assets/libs/node-waves/waves.min.js"></script>
        <script src="<?php echo base_url();?>assets/admin/assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
        <script src="<?php echo base_url();?>assets/admin/assets/libs/jquery.counterup/jquery.counterup.min.js"></script>

        <script src="<?php echo base_url();?>assets/admin/assets/js/app.js"></script>

    </body>
</html>