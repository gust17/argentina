<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="utf-8">
	<title>Erro no banco de dados</title>
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

		#container {
			margin: 20px;
		}

		p {
			margin: 12px;
		}
	</style>
	<link rel="stylesheet" type="text/css" href="https://cuenta.wcttrade.com/assets/cliente/iofrm/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cuenta.wcttrade.com/assets/cliente/iofrm/css/fontawesome-all.min.css">
	<link rel="stylesheet" type="text/css" href="https://cuenta.wcttrade.com/assets/cliente/iofrm/css/iofrm-style.css">
	<link rel="stylesheet" type="text/css" href="https://cuenta.wcttrade.com/assets/cliente/iofrm/css/iofrm-theme12.css">
</head>

<body>
	<div id="container">
		<code>
			<h5><?php echo $heading; ?></h5>
			<hr>
			<?php echo $message; ?>
		</code>
	</div>
</body>

</html>