<!DOCTYPE html>
<html lang="pt-br">

<head>

    <title><?php echo $this->lang->line('criar_cadastro'); ?> - <?php echo NOME_SITE; ?></title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="description" content="<?php echo SystemInfo('descricao_site'); ?>" />
    <meta name="keywords" content="investimentos, banco digital, renda variavel, marketing multinivel, mmn">
    <meta name="generator" content="<?php echo NOME_SITE; ?>">
    <meta name="robots" content="index follow">
    <meta name="application-name" content="<?php echo NOME_SITE; ?>">
    <meta http-equiv="content-language" content="pt-br">
    <meta name="author" content="<?php echo NOME_SITE; ?>">
    <meta name="creator" content="<?php echo NOME_SITE; ?>">

    <meta property="og:url" content="<?php echo base_url(); ?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Acessar minha conta - <?php echo NOME_SITE; ?>">
    <meta property="og:description" content="<?php echo SystemInfo('descricao_site'); ?>">
    <meta property="og:image" content="<?php echo base_url('assets/cliente/default/assets/images/logo.svg') ?>">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="<?php echo base_url(); ?>">
    <meta property="twitter:url" content="<?php echo base_url(); ?>">
    <meta name="twitter:title" content="Acessar minha conta - <?php echo NOME_SITE; ?>">
    <meta name="twitter:description" content="<?php echo SystemInfo('descricao_site'); ?>">
    <meta name="twitter:image" content="<?php echo base_url('assets/cliente/default/assets/images/logo.svg') ?>">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/cliente/iofrm/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/cliente/iofrm/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/cliente/iofrm/css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/cliente/iofrm/css/iofrm-theme27.css">

    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>assets/pages/img/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url('assets/cliente/default/assets/images/icone-pix.svg') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('assets/cliente/default/assets/images/icone-pix.svg') ?>">
    <link rel="manifest" href="<?php echo base_url(); ?>site.webmanifest">
    <link rel="mask-icon" href="<?php echo base_url(); ?>assets/pages/img/icons/safari-pinned-tab.svg" color="#000">
    <meta name="msapplication-TileColor" content="#000">
    <meta name="theme-color" content="#ffffff">

    <?php echo SystemInfo('google_analytics'); ?>
</head>

<body>

    <div class="form-body without-side">
        <div class="website-logo d-none">
            <div class="logo">
                <img src="<?php echo base_url('assets/cliente/default/assets/images/logo.svg') ?>" alt="">
            </div>
        </div>
        <div class="row">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <img src="<?php echo base_url('assets/cliente/default/assets/images/icone-pix.svg') ?>" alt="">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <div class="form-icon">
                            <div class="icon-holder"><img src="<?php echo base_url('assets/cliente/default/assets/images/icone-pix-white.svg') ?>" alt=""></div>
                        </div>
                        <h3 class="form-title-center">
                            Registro
                        </h3>
                        <p class="text-center">Regístrese en  <b>WCT Trade</b></p>

                        <?php if (isset($message)) echo $message; ?>

                        <form action="" method="post" id="cadastrarme">

                            <fieldset>
                                <div class="form-card">

                                    <input type="text" class="form-control" name="patrocinador" value="<?php echo $this->lang->line('c_f_patrocinador'); ?>: <?php echo $patrocinador['nome']; ?>" readonly>

                                    <select name="tipo_cadastro" class="form-control mb-3">
                                        <?php
                                        foreach (TiposCadastro() as $nTipo => $tipo) {
                                        ?>
                                            <option value="<?php echo $nTipo; ?>" <?php echo set_select('tipo_cadastro', $nTipo); ?>><?php echo $tipo; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>

                                    <input type="text" class="form-control" name="nome" placeholder="<?php echo $this->lang->line('c_f_nome'); ?>" value="<?php echo set_value('nome', ''); ?>" required>

                                    <input type="email" class="form-control" name="email" placeholder="<?php echo $this->lang->line('c_f_email'); ?>" value="<?php echo set_value('email', ''); ?>" required>

                                    <select name="ddi" class="form-control mb-3">
                                        <?php
                                        foreach ($ddis as $ddi) {
                                            // $selected = ($ddi->code == '+55') ? 'selected' : '';

                                            $selected =  set_select('ddi', $ddi->code, (($ddi->code == '+54') ? true : false));

                                            echo '<option value="' . $ddi->code . '" ' . $selected . '>' . $ddi->code . ' - ' . $ddi->name . '</option>';
                                        }
                                        ?>
                                    </select>

                                    <input type="text" class="form-control" name="celular" placeholder="Nr Telf" value="<?php echo set_value('celular', ''); ?>" required>
                                    <input type="text" class="form-control" name="data_nascimento" placeholder="<?php echo $this->lang->line('c_f_data_nascimento'); ?>" value="<?php echo set_value('data_nascimento', ''); ?>" required>

                                    <input type="text" class="form-control" name="documento" placeholder="<?php echo $this->lang->line('c_f_documento'); ?>" value="<?php echo set_value('documento', ''); ?>" autocomplete="off" required>

                                    <select name="sexo" class="form-control mb-3" required>
                                        <option value="1" <?php echo set_select('sexo', '1', true); ?>><?php echo $this->lang->line('c_f_s_masculino'); ?></option>
                                        <option value="2" <?php echo set_select('sexo', '2'); ?>><?php echo $this->lang->line('c_f_s_feminino'); ?></option>
                                        <option value="3" <?php echo set_select('sexo', '3'); ?>><?php echo $this->lang->line('c_f_s_nao_informar'); ?></option>
                                    </select>

                                    <input type="text" class="form-control" name="login" placeholder="Usuario" value="<?php echo set_value('login', ''); ?>" required>

                                    <input type="password" class="form-control" name="senha" placeholder="Senha" value="<?php echo set_value('senha', ''); ?>" required>

                                    <input type="password" class="form-control" name="senha_confirmar" placeholder="Confirmar Senha" value="<?php echo set_value('senha_confirmar', ''); ?>" required>

                                </div>
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                <div class="form-button">
                                    <button type="submit" name="submit" class="ibtn ibtn-full" value="submit" data-step="1">Registrame</button>
                                </div>
                            </fieldset>

                            <div class="text-center mt-4">
                                <small>¿Ya tienes una cuenta?</small>
                            </div>
                            <div class="text-center form-button mt-2">
                                <a href="<?php echo base_url($rotas->login); ?>" class="">Iniciar sesión</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        var baseURL = '<?php echo base_url(); ?>';
    </script>
    <script src="<?php echo base_url(); ?>assets/cliente/iofrm/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/cliente/iofrm/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/cliente/iofrm/s/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/cliente/iofrm/js/main.js"></script>

    <!-- Required Js -->
    <script src="<?php echo base_url(); ?>assets/cliente/default/assets/js/vendor-all.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/cliente/default/assets/js/plugins/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/cliente/default/assets/js/plugins/feather.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/cliente/default/assets/js/pcoded.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/maskedinput/jquery.maskedinput.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-notify/bootstrap-notify.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/pages/js/geral.js"></script>
    <script src="<?php echo base_url(); ?>assets/pages/js/cadastro2.js"></script>
    <script type="module">
        import 'https://cdn.jsdelivr.net/npm/@pwabuilder/pwaupdate';
        const el = document.createElement('pwa-update');
        document.body.appendChild(el);
    </script>
    <?php echo $this->recaptcha->getScriptTag(); ?>
    <?php echo $this->recaptcha->getWidget('cadastrarme'); ?>
</body>

</html>