<?php
$rotas = MinhasRotas();
$userName = UserInfo('nome');
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<title><?php echo $nome_pagina; ?> - <?php echo NOME_SITE; ?></title>
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

	<!-- font css -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/cliente/default/assets/fonts/font-awsome-pro/css/pro.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/cliente/default/assets/fonts/feather.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/cliente/default/assets/fonts/fontawesome.css">

	<!-- vendor css -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/cliente/default/assets/css/style-dark.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/cliente/default/assets/css/customizer.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/cliente/default/assets/css/layout-horizontal.css">

	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/cliente/default/assets/css/plugins/animate.min.css">


	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>assets/pages/img/icons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>assets/pages/img/icons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/pages/img/icons/favicon-16x16.png">
	<link rel="manifest" href="<?php echo base_url(); ?>site.webmanifest">
	<link rel="mask-icon" href="<?php echo base_url(); ?>assets/pages/img/icons/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#000">
	<meta name="theme-color" content="#ffffff">

	<script type="module" crossorigin src="<?php echo base_url(); ?>assets/pages/backoffice/index.2136ee3c.js"></script>
	<link rel="modulepreload" href="<?php echo base_url(); ?>assets/pages/backoffice/vendor.4d54a1d2.js">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/pages/backoffice/index.49987aed.css">

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

	<?php
	if (isset($cssLoader)) {
		foreach ($cssLoader as $file) {
			$url = (is_file($file)) ? base_url($file) : $file;
			echo '<link rel="stylesheet" href="' . $url . '">' . PHP_EOL;
		}
	}
	?>

	<?php echo SystemInfo('google_analytics'); ?>

	<!-- PushAlert -->
	<script type="text/javascript">
		(function(d, t) {
			var g = d.createElement(t),
				s = d.getElementsByTagName(t)[0];
			g.src = "https://cdn.pushalert.co/integrate_189da1b0322e42f2d9204be1d0da2ca2.js";
			s.parentNode.insertBefore(g, s);
		}(document, "script"));
	</script>
	<!-- End PushAlert -->
</head>

<body class="pc-horizontal">
	<div class="container">
		<!-- [ Pre-loader ] start -->
		<div class="loader-bg">
			<div class="loader-track">
				<div class="loader-fill"></div>
			</div>
		</div>
		<!-- [ Pre-loader ] End -->
		<!-- [ Mobile header ] start -->
		<div class="pc-mob-header pc-header bg-warning">
			<div class="pcm-logo" style="filter:brightness(200%) !important">
				<a href="<?php echo base_url() ?>">
					<img src="<?php echo base_url('assets/cliente/default/assets/images/icons/64px/2.svg') ?>" width="50" height="50" alt="" class="img-fluid">
				</a>
			</div>
			<!-- <div class="pcm-toolbar">
				<a href="#!" class="pc-head-link"  data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
					<div class="hamburger hamburger--arrowturn">
						<div class="hamburger-box">
							<div class="hamburger-inner"></div>
						</div>
					</div>
				</a>
			</div> -->
		</div>
		<!-- [ Mobile header ] End -->

		<!-- [ navigation menu ] start -->
		<nav class="topbar ">
			<div class="container">
				<div class="navbar-wrapper">

					<!-- MENU -->
					<header class="header-banner-top">

						<nav class="navbar navbar-expand-lg navbar-dark">
							<!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="true" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon text-secondary"></span>
						</button> -->
							<div class="navbar-collapse" id="navbarText">
								<ul class="navbar-nav m-auto text-uppercase">

									<!-- item -->
									<li class="nav-item active">
										<a class="nav-link " href="<?php echo base_url($rotas->backoffice); ?>">
											<img src="<?php echo base_url('assets/cliente/default/assets/images/menu-icons/home.svg') ?>" width="20" height="20" alt="" class="img-fluid mr-1">
											<span class=""><?php echo $this->lang->line('menu_backoffice'); ?></span>
											<span class="sr-only">(current)</span>
										</a>
									</li>
									<!-- .item -->

									<!-- dropdown -->
									<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle" href="#" id="menu_planos" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<img src="<?php echo base_url('assets/cliente/default/assets/images/menu-icons/wallet.svg') ?>" width="20" height="20" alt="" class="img-fluid mr-1">
											<span class=""><?php echo $this->lang->line('menu_planos'); ?></span>
										</a>
										<div class="dropdown-menu" aria-labelledby="menu_planos">
											<a class="dropdown-item" href="<?php echo base_url($rotas->faturas_lista); ?>"> <?php echo $this->lang->line('menu_faturas'); ?></a>
											<a class="dropdown-item" href="<?php echo base_url($rotas->planos_comprar); ?>"> <?php echo $this->lang->line('menu_planos_comprar'); ?></a>
											<a class="dropdown-item" href="<?php echo base_url($rotas->planos_ativos); ?>"> <?php echo $this->lang->line('menu_planos_ativos'); ?></a>
											<a class="dropdown-item" href="<?php echo base_url($rotas->planos_expirados); ?>"> <?php echo $this->lang->line('menu_planos_expirados'); ?></a>
										</div>
									</li>
									<!-- .dropdown -->

									<!-- dropdown -->
									<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle" href="#" id="menu_indicados" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<img src="<?php echo base_url('assets/cliente/default/assets/images/menu-icons/users.svg') ?>" width="20" height="20" alt="" class="img-fluid mr-1">
											<span class=""><?php echo $this->lang->line('menu_indicados'); ?></span>
										</a>
										<div class="dropdown-menu" aria-labelledby="menu_indicados">
											<a class="dropdown-item" href="<?php echo base_url($rotas->indicados_ativos); ?>"> <?php echo $this->lang->line('menu_indicados_ativos'); ?></a>
											<a class="dropdown-item" href="<?php echo base_url($rotas->indicados_pendentes); ?>"> <?php echo $this->lang->line('menu_indicados_pendentes'); ?></a>
											<a class="dropdown-item" href="<?php echo base_url($rotas->indicados_unilevel); ?>"> <?php echo $this->lang->line('menu_indicados_rede_unilevel'); ?></a>
											<a class="dropdown-item" href="<?php echo base_url($rotas->indicados_relatorio); ?>"> <?php echo $this->lang->line('menu_relatorio_rede'); ?></a>
										</div>
									</li>
									<!-- .dropdown -->

									<!-- dropdown -->
									<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle" href="#" id="menu_saques" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<img src="<?php echo base_url('assets/cliente/default/assets/images/menu-icons/banknotes.svg') ?>" width="20" height="20" alt="" class="img-fluid mr-1">
											<span class=""><?php echo $this->lang->line('menu_saques'); ?></span>
										</a>
										<div class="dropdown-menu" aria-labelledby="menu_saques">
											<a class="dropdown-item" href="<?php echo base_url($rotas->saques_lista); ?>"> <?php echo $this->lang->line('menu_saques_relatorio'); ?></a>
											<a class="dropdown-item" href="<?php echo base_url($rotas->saques_rede); ?>"> <?php echo $this->lang->line('menu_saques_rede'); ?></a>
											<hr />
											<a class="dropdown-item" href="<?php echo base_url($rotas->extrato_geral); ?>"> <?php echo $this->lang->line('menu_extratos_geral'); ?></a>
											<a class="dropdown-item" href="<?php echo base_url($rotas->extrato_rendimento); ?>"> <?php echo $this->lang->line('menu_extratos_rendimento'); ?></a>
											<a class="dropdown-item" href="<?php echo base_url($rotas->extrato_rede); ?>"> <?php echo $this->lang->line('menu_extratos_rede'); ?></a>
										</div>
									</li>
									<!-- .dropdown -->

									<!-- dropdown -->
									<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle" href="#" id="menu_perfil" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<img src="<?php echo base_url('assets/cliente/default/assets/images/menu-icons/cog.svg') ?>" width="20" height="20" alt="" class="img-fluid mr-1">
											<span class=""><?php echo $this->lang->line('menu_perfil'); ?></span>
										</a>
										<div class="dropdown-menu" aria-labelledby="menu_perfil">
											<a class="dropdown-item" href="<?php echo base_url($rotas->dados_perfil); ?>"> <?php echo $this->lang->line('menu_perfil_dados'); ?></a>
											<a class="dropdown-item" href="<?php echo base_url($rotas->dados_senha); ?>"> <?php echo $this->lang->line('menu_perfil_senha'); ?></a>
											<a class="dropdown-item" href="<?php echo base_url($rotas->contas_pix); ?>"> Mi cuenta</a>
										</div>
									</li>
									<!-- .dropdown -->

									<li class="nav-item text-dark d-none">
										<a class="nav-link" href="<?php echo base_url($rotas->sair); ?>">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: var(--dark);transform: ;msFilter:;">
												<path d="M19.002 3h-14c-1.103 0-2 .897-2 2v4h2V5h14v14h-14v-4h-2v4c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2V5c0-1.103-.898-2-2-2z"></path>
												<path d="m11 16 5-4-5-4v3.001H3v2h8z"></path>
											</svg>
										</a>
									</li>

								</ul>
							</div>
						</nav>

					</header>
					<!-- .MENU -->
				</div>
			</div>
		</nav>
		<!-- [ navigation menu ] end -->

		<!-- [ Mobile header ] start -->
		<div class="pc-mob-header pc-header">
			<div class="pcm-logo">
				<a href="<?php echo base_url() ?>">
					<img src="<?php echo base_url('assets/cliente/default/assets/images/logo.svg') ?>" alt="" width="100" height="25" alt="" class="img-fluid m-2">
				</a>
			</div>
			<li class="pc-h-item">
				<a class="pc-head-link mr-0 notificacaoTour" href="<?php echo base_url($rotas->notificacoes); ?>">
					<img src="<?php echo base_url('assets/cliente/default/assets/images/menu-icons/bell.svg'); ?>" width="20" height="20" alt="" class="">
					<?php if ($this->NotificacoesModel->TotalNotificacoes() > 0) { ?>
						<span class="badge badge-danger pc-h-badge dots">
							<span class="sr-only"></span>
						</span>
					<?php } ?>
				</a>
			</li>

			<div class="text-right ">
				<ul class="list-unstyled">
					<li class="dropdown pc-h-item">

					</li>
					<li>
						<?php
						if (UserInfo('is_admin') == 1) {
						?>
							<form action="<?php echo base_url($rotas->admin_login); ?>" method="post" target="_blank">
								<button class="btn btn-sm btn-outline-light text-uppercase" type="submit" name="submitAdmin" value="Logar no admin">
									<small>PAINEL</small>
								</button>
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
							</form>
						<?php
						}
						?>
					</li>

				</ul>
			</div>

			<div class="pcm-toolbar">
				<a href="#" class="pc-head-link" id="mobile-collapse">
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="true" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon text-secondary"></span>
						<div class="hamburger-box" style="filter:invert(1);">
							<div class="hamburger-inner"></div>
						</div>
					</button>
				</a>
			</div>
		</div>
		<!-- [ Mobile header ] End -->


		<!-- [ Header ] start -->
		<header class="pc-header ">
			<div class="header-wrapper">
				<a href="<?php echo base_url($rotas->backoffice); ?>" class="p-2">
					<img src="<?php echo base_url('assets/cliente/default/assets/images/logo.svg') ?>" alt="" width="100" height="25" alt="" class="img-fluid m-2">
				</a>
				<div class="ml-auto ">
					<ul class="list-unstyled">

						<li class="pc-h-item">
							<a class="pc-head-link mr-0 notificacaoTour" href="<?php echo base_url($rotas->notificacoes); ?>">
								<img src="<?php echo base_url('assets/cliente/default/assets/images/menu-icons/bell.svg'); ?>" width="24" height="24" alt="" class="">
								<?php if ($this->NotificacoesModel->TotalNotificacoes() > 0) { ?>
									<span class="badge badge-danger pc-h-badge dots">
										<span class="sr-only"></span>
									</span>
								<?php } ?>
							</a>
						</li>
						<li class="dropdown pc-h-item mr-2">
							<a class="pc-head-link dropdown-toggle arrow-none mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
								<img src="<?php echo base_url('assets/cliente/default/assets/images/bot/bot.png'); ?>" alt="" class="user-avtar">
								<span>
									<span class="user-name"><?php echo UserInfo('nome'); ?></span>
									<!-- <span class="user-desc"><?php echo PerfilUsuario(UserInfo('perfil')); ?></span> -->
								</span>
							</a>
							<div class="dropdown-menu dropdown-menu-right pc-h-dropdown">
								<div class=" dropdown-header d-none">
									<h6 class="text-overflow m-0"><?php echo $this->lang->line('bem_vindo'); ?></h6>
								</div>
								<?php
								if (UserInfo('is_admin') == 1) {
								?>
									<a href="javascript:void(0);" class="dropdown-item">
										<form action="<?php echo base_url($rotas->admin_login); ?>" method="post" target="_blank">
											<button class="btn btn-secondary btn-block" type="submit" name="submitAdmin" value="Logar no admin">PAINEL</button>
											<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
										</form>
									</a>
								<?php
								}
								?>
								<a href="<?php echo base_url($rotas->dados_perfil); ?>" class="dropdown-item">
									<img src="<?php echo base_url('assets/cliente/default/assets/images/menu-icons/cog.svg') ?>" width="20" height="20" alt="" class="img-fluid mr-1">
									<small><?php echo $this->lang->line('dropdown_dados_pessoais'); ?></small>
								</a>
								<a href="<?php echo base_url($rotas->dados_senha); ?>" class="dropdown-item">
									<img src="<?php echo base_url('assets/cliente/default/assets/images/menu-icons/key.svg') ?>" width="20" height="20" alt="" class="img-fluid mr-1">
									<small><?php echo $this->lang->line('dropdown_trocar_senha'); ?></small>
								</a>
								<a href="<?php echo base_url($rotas->sair); ?>" class="dropdown-item">
									<img src="<?php echo base_url('assets/cliente/default/assets/images/menu-icons/exit.svg') ?>" width="20" height="20" alt="" class="img-fluid mr-1">
									<small><?php echo $this->lang->line('dropdown_sair'); ?></small>
								</a>
							</div>
						</li>
					</ul>
				</div>

			</div>
		</header>
		<!-- [ Header ] end -->

		<!-- [ Main Content ] start -->
		<div class="pc-container">
			<button class="btn btn-success d-none" id="installApp">Install App</button>
			<?php echo $contents; ?>
		</div>
	</div>


	<div vw class="enabled">
		<div vw-access-button class="active"></div>
		<div vw-plugin-wrapper>
			<div class="vw-plugin-top-wrapper"></div>
		</div>
	</div>
	<script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
	<script>
		new window.VLibras.Widget('https://vlibras.gov.br/app');
	</script>

	<?php
	if (UserInfo('perfil') >= 3) {
	?>
		<script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=486facfd-540b-4f30-8d68-f1e13c31e7bb"></script>
	<?php
	}
	?>

	<script>
		var baseURL = '<?php echo base_url(); ?>';
		var linkIndicacaoJS = '<?php echo base_url(); ?><?php echo $rotas->cadastro; ?>?<?php echo SystemInfo('query_string_patrocinador'); ?>=<?php echo UserInfo('codigo_patrocinio'); ?>';
	</script>
	<!-- VAR -->
	<?php
	if (isset($jsVar)) {
	?>
		<script>
			<?php
			foreach ($jsVar as $nameVar => $valueVar) {
				echo 'var ' . $nameVar . ' = "' . $valueVar . '";' . PHP_EOL;
			}
			?>
		</script>
	<?php
	}
	?>
	<!-- Required Js -->
	<script src="<?php echo base_url(); ?>assets/cliente/default/assets/js/vendor-all.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/cliente/default/assets/js/plugins/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-notify/bootstrap-notify.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/cliente/default/assets/js/plugins/feather.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/cliente/default/assets/js/pcoded.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="<?php echo base_url(); ?>assets/pages/js/geral.js"></script>
	<script type="module">
		import 'https://cdn.jsdelivr.net/npm/@pwabuilder/pwaupdate';
		const el = document.createElement('pwa-update');
		document.body.appendChild(el);
	</script>
	<!-- custom-chart js -->
	<?php
	if (isset($jsLoader)) {
		foreach ($jsLoader as $file) {
			$url = (is_file($file)) ? base_url($file) : $file;
			echo '<script src="' . $url . '"></script>' . PHP_EOL;
		}
	}
	?>

	<script>


	</script>

</body>

</html>