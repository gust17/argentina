<!DOCTYPE html>
<html lang="pt-br">

<head>

    <title><?php echo $this->lang->line('login_titulo'); ?> - <?php echo NOME_SITE; ?></title>
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
        <div class="website-logo">
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
                            Login
                        </h3>
                        <p class="text-center">Faça login na plataforma <b>WCT Trade</b></p>

                        <?php if (isset($message)) echo $message; ?>

                        <form action="<?php echo base_url($rotas->login); ?>" method="post" id="login_site">

                            <input class="form-control" type="text" name="login" placeholder="<?php echo $this->lang->line('login_login_informe'); ?>" required>
                            <input class="form-control" type="password" name="senha" placeholder="<?php echo $this->lang->line('login_senha_informe'); ?>" required>

                            <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />

                            <div class="form-button">
                                <button id="submit" name="submit" type="submit" value="submit" class="ibtn ibtn-full">
                                    <?php echo $this->lang->line('login_fazer_login_button'); ?>
                                </button>
                            </div>
                            <div class="text-center mt-4">
                                <a href="<?php echo base_url($rotas->recuperar_senha); ?>" class="text-dark"><small><?php echo $this->lang->line('login_esqueceu_senha'); ?></small></a>
                            </div>
                            <div class="text-center form-button mt-4">
                                <a href="<?php echo base_url($rotas->cadastro); ?>" class=""><?php echo $this->lang->line('login_criar_cadastro_button'); ?></a>
                            </div>
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url(); ?>assets/cliente/iofrm/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/cliente/iofrm/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/cliente/iofrm/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/cliente/iofrm/js/main.js"></script>
    <script type="module">
        import 'https://cdn.jsdelivr.net/npm/@pwabuilder/pwaupdate';
        const el = document.createElement('pwa-update');
        document.body.appendChild(el);
    </script>

    <?php echo $this->recaptcha->getScriptTag(); ?>
    <?php echo $this->recaptcha->getWidget('login_site'); ?>
</body>

</html>