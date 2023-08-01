<?php

use Twilio\Rest\Client;

function EnviarSMS($numero, $mensagem, $page = false)
{

    // $habilitado = SystemInfo('twilio_sms_habilitar');
    // $paginas = SystemInfo('twilio_sms_paginas');
    // $sid = SystemInfo('twilio_sms_sid');
    // $token = SystemInfo('twilio_sms_token');
    // $serviceID = SystemInfo('twilio_sms_service_id');

    // if ($habilitado == 1) {

    //     if ($page) {

    //         $pages = json_decode($paginas, true);

    //         if (!in_array($page, $pages)) {

    //             return;
    //         }
    //     }

    //     $numero = str_replace(array(' ', '-', '.', '(', ')'), array('', '', '', '', ''), $numero);

    //     $twilio = new Client($sid, $token);

    //     $message = $twilio->messages
    //         ->create(
    //             $numero,
    //             array(
    //                 "messagingServiceSid" => $serviceID,
    //                 "body" => $mensagem
    //             )
    //         );

    //     return true;
    // }
}
