<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function EnviarEmail($para, $assunto, $mensagem)
{

    $mail = new PHPMailer(true);

    try {

        $mail->SMTPDebug = 0;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host       = EMAIL_HOST;                             // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = EMAIL_SITE;                             // SMTP username
        $mail->Password   = EMAIL_SENHA;                            // SMTP password
        $mail->SMTPSecure = EMAIL_ENCRYPT;                                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = EMAIL_PORTA;                                    // TCP port to connect to

        $mail->setFrom(EMAIL_SITE, NOME_SITE);
        $mail->addAddress($para);

        $mail->isHTML(true);
        $mail->Subject = $assunto;
        $mail->Body    = $mensagem;
        $mail->AltBody = '';

        $mail->send();

        return true;
    } catch (Exception $e) {

        return false;
    }
}
