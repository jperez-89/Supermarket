<?php

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

// esta es la funcion que se utiliza en el sistema de Smarticket
function correo2($email, $subject, $message, $adjunto = '')
{
    require 'vendor/autoload.php';

    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "smtp.office365.com";
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->Username = 'noreply@smarticket.net';
    $mail->Password = 'Mol61129';

    $mail->AddAddress($email);
    $mail->SetFrom('noreply@smarticket.net', 'NoReply');
    $mail->IsHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;

    $mail->addAttachment($adjunto);

    try {
        $mail->Send();
        return true;
    } catch (Exception $e) {
        return "Error " . $mail->ErrorInfo;
    }
}
