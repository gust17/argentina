<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Ocorreu um erro com excessão ao executar o script</title>
		<style type="text/css">
			code {
				font-family: var(--font-family-monospace);
				font-size: 12px;
				background-color: #000;
				color: var(--white) !important;
				display: block;
				margin: 14px 0 14px 0;
				padding: 24px;
				border-radius: 10px !important;
			}
			#container {margin: 20px;} p {margin: 12px;}
		</style>
    <link rel="stylesheet" type="text/css" href="assets/cliente/iofrm/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/cliente/iofrm/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/cliente/iofrm/css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="assets/cliente/iofrm/css/iofrm-theme12.css">
</head>
<body>
	<div id="container">
		<code>
			<p>Tipo: <?php echo get_class($exception); ?></p>
			<p>Mensagem: <?php echo $message; ?></p>
			<p>Arquivo: <?php echo $exception->getFile(); ?></p>
			<p>Linha: <?php echo $exception->getLine(); ?></p>

			<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

				<p>Backtrace:</p>
				<?php foreach ($exception->getTrace() as $error): ?>

					<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

						<p style="margin-left:10px">
						Arquivo: <?php echo $error['file']; ?><br />
						Linha: <?php echo $error['line']; ?><br />
						Função: <?php echo $error['function']; ?>
						</p>
					<?php endif ?>

				<?php endforeach ?>

			<?php endif ?>
		</code>
	</div>
</body>
</html>