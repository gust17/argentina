
<?php
$rotas = MinhasRotas();
$this->permission->setConstPermissions();
?>
<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>Administração Geral - <?php echo NOME_SITE;?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <meta name="robots" content="noindex, nofollow">
        <meta name="googlebot" content="noindex, nofollow">

        <!-- Bootstrap Css -->
        <link href="<?php echo base_url();?>assets/admin/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?php echo base_url();?>assets/admin/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?php echo base_url();?>assets/admin/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- Animate CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/cliente/default/assets/css/plugins/animate.min.css">

        <?php
        if(isset($cssLoader)){
            foreach($cssLoader as $file){
                $url = (is_file($file)) ? base_url($file) : $file;
                echo '<link rel="stylesheet" href="'.$url.'">'.PHP_EOL;
            }
        }
        ?>

    </head>

    <!-- <body> -->
    <body data-layout="horizontal" data-topbar="colored">

        <!-- Begin page -->
        <div id="layout-wrapper">

            
            

            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="<?php echo base_url($rotas->admin_dashboard);?>" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="<?php echo base_url();?>assets/admin/assets/images/logo-sm.png" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="<?php echo base_url();?>assets/admin/assets/images/logo-dark.png" alt="" height="20">
                                </span>
                            </a>

                            <a href="<?php echo base_url($rotas->admin_dashboard);?>" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="<?php echo base_url();?>assets/admin/assets/images/logo-sm.png" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="<?php echo base_url();?>assets/admin/assets/images/logo-light.png" alt="" height="20">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-toggle="collapse" data-target="#topnav-menu-content">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>

                    </div>

                    <div class="d-flex">

                        <div class="dropdown d-none d-lg-inline-block ml-1">
                            <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                                <i class="uil-minus-path"></i>
                            </button>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="<?php echo base_url();?>assets/admin/assets/images/users/avatar-7.jpg"
                                    alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ml-1 font-weight-medium font-size-15">Administrador</span>
                                <i class="uil-angle-down d-none d-xl-inline-block font-size-15"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <!-- item-->
                                <?php
                                if($this->permission->Authorization('configuracoes.site')){
                                ?>
                                <a class="dropdown-item d-block" href="<?php echo base_url($rotas->admin_configuracoes_site);?>"><i class="uil uil-cog font-size-18 align-middle mr-1 text-muted"></i> <span class="align-middle">Configurações do site</span></a>
                                <?php
                                }
                                ?>
                                <a class="dropdown-item" href="<?php echo base_url($rotas->admin_logout);?>"><i class="uil uil-sign-out-alt font-size-18 align-middle mr-1 text-muted"></i> <span class="align-middle">Sair</span></a>
                            </div>
                        </div>
            
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="topnav">

                        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
    
                            <div class="collapse navbar-collapse" id="topnav-menu-content">
                                <ul class="navbar-nav">

                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo base_url($rotas->admin_dashboard);?>">
                                            <i class="uil-home-alt mr-2"></i> Dashboard
                                        </a>
                                    </li>

                                    <?php
                                    if($this->permission->Authorization('usuarios')){
                                    ?>
    
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="uil-user mr-2"></i>Usuários <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-pages">
                                            <?php
                                            if($this->permission->Authorization('usuarios.todos')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_usuarios_todos);?>" class="dropdown-item"><b>Todos os usuários</b></a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('usuarios.ativos')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_usuarios_ativos);?>" class="dropdown-item">Usuários ativos</a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('usuarios.pendentes')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_usuarios_pendentes);?>" class="dropdown-item">Usuários pendentes</a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('validacao')){
                                            ?>
                                            <div class="dropdown">
                                                <a href="javascript:void(0);" id="topnav-docs" class="dropdown-item">Validação de Docs. <div class="arrow-down"></div> </a>

                                                <div class="dropdown-menu" aria-labelledby="topnav-docs">
                                                    <a href="<?php echo base_url($rotas->validacao_todos);?>" class="dropdown-item">Todos</a>
                                                    <a href="<?php echo base_url($rotas->validacao_aprovados);?>" class="dropdown-item">Aprovados</a>
                                                    <a href="<?php echo base_url($rotas->validacao_rejeitados);?>" class="dropdown-item">Rejeitados</a>
                                                </div>
                                            </div>
                                            <?php
                                            }
                                            ?>

                                        </div>
                                    </li>
                                    <?php
                                    }
                                    ?>

                                    <?php
                                    if($this->permission->Authorization('faturas')){
                                    ?>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="uil-document-info mr-2"></i>Faturas <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-pages">
                                            <?php
                                            if($this->permission->Authorization('faturas.todas')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_faturas_todas);?>" class="dropdown-item"><b>Todas as Faturas</b></a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('faturas.pendentes')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_faturas_pendentes);?>" class="dropdown-item">Faturas Pendentes</a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('faturas.ativas')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_faturas_ativas);?>" class="dropdown-item">Faturas Ativas</a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('faturas.expiradas')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_faturas_expiradas);?>" class="dropdown-item">Faturas Expiradas</a>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </li>
                                    <?php
                                    }
                                    ?>

                                    <?php
                                    if($this->permission->Authorization('comprovantes')){
                                    ?>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="uil-file-info-alt mr-2"></i>Comprovantes <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-pages">

                                            <?php
                                            if($this->permission->Authorization('comprovantes.todos')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_comprovantes_todos);?>" class="dropdown-item"><b>Todos os Comprovantes</b></a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('comprovantes.pendentes')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_comprovantes_pendentes);?>" class="dropdown-item">Comprovantes Pendentes</a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('comprovantes.aprovados')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_comprovantes_aprovados);?>" class="dropdown-item">Comprovantes Aprovados</a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('comprovantes.rejeitados')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_comprovantes_rejeitados);?>" class="dropdown-item">Comprovantes Rejeitados</a>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </li>
                                    <?php
                                    }
                                    ?>

                                    <?php
                                    if($this->permission->Authorization('saques')){
                                    ?>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="uil-dollar-alt mr-2"></i>Saques <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-pages">

                                            <?php
                                            if($this->permission->Authorization('saques.todos')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_saques_todos);?>" class="dropdown-item"><b>Todos os Saques</b></a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('saques.pendentes')){
                                            ?>
                                            <div class="dropdown">
                                                <a href="javascript:void(0);" id="topnav-ecommerce" class="dropdown-item">Saques Pendentes <div class="arrow-down"></div> </a>

                                                <div class="dropdown-menu" aria-labelledby="topnav-ecommerce">
                                                    <a href="<?php echo base_url($rotas->admin_saques_pendentes);?>" class="dropdown-item">Pendentes sem urgência</a>
                                                    <a href="<?php echo base_url($rotas->admin_saques_pendentes_urgencia);?>" class="dropdown-item">Pendentes com urgência</a>
                                                </div>
                                            </div>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('saques.pagos')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_saques_pagos);?>" class="dropdown-item">Saques Pagos</a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('saques.estornados')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_saques_estornados);?>" class="dropdown-item">Saques Estornados</a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('saques.previsao')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_saques_previsao);?>" class="dropdown-item"><b>Previsão de saque</b></a>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </li>
                                    <?php
                                    }
                                    ?>

                                    <?php
                                    if($this->permission->Authorization('tarefas')){
                                    ?>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="uil-file-info-alt mr-2"></i>Tarefas <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-pages">

                                            <?php
                                            if($this->permission->Authorization('tarefas.pendentes')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_tarefas_todas);?>" class="dropdown-item">Tarefas Pendentes</a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('tarefas.aprovadas')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_tarefas_aprovadas);?>" class="dropdown-item">Tarefas Aprovados</a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('tarefas.rejeitados')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_tarefas_rejeitadas);?>" class="dropdown-item">Tarefas Rejeitados</a>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </li>
                                    <?php
                                    }
                                    ?>

                                    <?php
                                    if($this->permission->Authorization('pesquisas')){
                                    ?>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="uil-file-info-alt mr-2"></i>Pesquisas <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-pages">

                                            <?php
                                            if($this->permission->Authorization('pesquisas.sistema')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_pesquisas_satisfacao);?>" class="dropdown-item">Pesquisa satisfação</a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('pesquisas.patrocinador')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_pesquisas_patrocinador);?>" class="dropdown-item">Pesquisa patrocinador</a>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </li>
                                    <?php
                                    }
                                    ?>

                                    <?php
                                    if($this->permission->Authorization('caixa')){
                                    ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo base_url($rotas->admin_caixa);?>">
                                            <i class="uil-exchange-alt mr-2"></i> Caixa
                                        </a>
                                    </li>
                                    <?php
                                    }
                                    ?>

                                    <?php
                                    if($this->permission->Authorization('relatorios')){
                                    ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo base_url($rotas->admin_relatorios);?>">
                                            <i class="uil-graph-bar mr-2"></i> Relatórios
                                        </a>
                                    </li>
                                    <?php
                                    }
                                    ?>

                                    <?php
                                    if($this->permission->Authorization('configuracoes')){
                                    ?>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="uil-cog mr-2"></i>Configurações <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-pages">

                                            <?php
                                            if($this->permission->Authorization('configuracoes.pacotes')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_pacotes_todos);?>" class="dropdown-item">Pacotes de Adesão</a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('configuracoes.contas_bancarias')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_contas_todas);?>" class="dropdown-item">Contas Bancárias</a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('configuracoes.grupos')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_configuracoes_grupos);?>" class="dropdown-item">Configurações de Grupos</a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('configuracoes.site')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_configuracoes_site);?>" class="dropdown-item">Configurações do Site</a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('configuracoes.saque')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_configuracoes_saque);?>" class="dropdown-item">Configurações de Saque</a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('configuracoes.rotas')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_configuracoes_rotas_todas);?>" class="dropdown-item">Configurações de Rotas</a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('configuracoes.pix')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_configuracoes_pix);?>" class="dropdown-item">Configurações API Pix</a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('configuracoes.twillio')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_configuracoes_api_twilio);?>" class="dropdown-item">Configurações API Twilio</a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('configuracoes.asaas')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_configuracoes_api_asaas);?>" class="dropdown-item">Configurações API Asaas</a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('configuracoes.bankon')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_configuracoes_api_bankon);?>" class="dropdown-item">Configurações API BankOn</a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('configuracoes.simplepay')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_configuracoes_api_simplepay);?>" class="dropdown-item">Configurações API SimplePay</a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('configuracoes.coinpayments')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_configuracoes_api_coinpayments);?>" class="dropdown-item">Configurações API CoinPayments</a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('configuracoes.recaptcha')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_configuracoes_api_recaptcha);?>" class="dropdown-item">Configurações API Recaptcha</a>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if($this->permission->Authorization('configuracoes.telegram')){
                                            ?>
                                            <a href="<?php echo base_url($rotas->admin_configuracoes_api_telegram);?>" class="dropdown-item">Configurações API Telegram</a>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </li>
                                    <?php
                                    }
                                    ?>
    
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </header>
    


            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0"><?php echo $nome_pagina;?></h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <?php echo $contents;?>
                        <!-- End Page-content -->

                    </div>
                </div>
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © <?php echo NOME_SITE;?>.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-right d-none d-sm-block">
                                    Programação desenvolvida <i class="mdi mdi-heart text-danger"></i> por <a href="http://api.whatsapp.com/send?phone=5511947772188" target="_blank" class="text-reset">Alisson Acioli</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->
        
        <script>
            var baseURL = '<?php echo base_url();?>';
            var MOEDA_ATUAL = '<?php echo MOEDA;?>';
        </script>
        <!-- JAVASCRIPT -->
        <script src="<?php echo base_url();?>assets/admin/assets/libs/jquery/jquery.min.js"></script>
        <script src="<?php echo base_url();?>assets/admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo base_url();?>assets/admin/assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="<?php echo base_url();?>assets/admin/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="<?php echo base_url();?>assets/admin/assets/libs/node-waves/waves.min.js"></script>
        <script src="<?php echo base_url();?>assets/admin/assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
        <script src="<?php echo base_url();?>assets/admin/assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/bootstrap-notify/bootstrap-notify.min.js"></script>

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <script src="<?php echo base_url();?>assets/pages/js/geral.js"></script>

        <?php
        if(isset($jsLoader)){
            foreach($jsLoader as $file){
                $url = (is_file($file)) ? base_url($file) : $file;
                echo '<script src="'.$url.'"></script>'.PHP_EOL;
            }
        }
        ?>

        <script src="<?php echo base_url();?>assets/admin/assets/js/app.js"></script>

    </body>

</html>