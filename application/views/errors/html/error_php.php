<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="utf-8">
	<title>Um erro PHP foi encontrado</title>
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

			<p>Severity: <?php echo $severity; ?></p>
			<p>Message: <?php echo $message; ?></p>
			<p>Filename: <?php echo $filepath; ?></p>
			<p>Line Number: <?php echo $line; ?></p>

			<?php
			$this->sendMessageTelegram(
				'Severity: ' . $severity . PHP_EOL .
					'Message: ' . $message . PHP_EOL .
					'File: ' . $filepath . PHP_EOL .
					'Line: ' . $line
			);
			?>

			<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE) : ?>

				<p>Backtrace:</p>
				<?php foreach (debug_backtrace() as $error) : ?>

					<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0) : ?>

						<p style="margin-left:10px">
							File: <?php echo $error['file'] ?><br />
							Line: <?php echo $error['line'] ?><br />
							Function: <?php echo $error['function'] ?>
						</p>

					<?php endif ?>

				<?php endforeach ?>

			<?php endif ?>

		</code>
	</div>
</body>

</html>