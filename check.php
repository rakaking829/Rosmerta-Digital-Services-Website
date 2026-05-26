<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'noreply.web@rosmertatech.com';
    $mail->Password = 'L$826992633603ak';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('noreply.web@rosmertatech.com', 'Rosmerta Web');
    $mail->addReplyTo('noreply.web@rosmertadigital.com', 'Rosmerta Digital');
    $mail->addAddress('support@smartech.co.in'); // Your test email
    

    $mail->isHTML(true);
    $mail->Subject = 'Test Reply-To';
    $mail->Body = 'Test body.<br>When you reply, it should go to noreply.web@rosmertadigital.com.';
    $mail->AltBody = 'Plain text version.';

    $mail->send();
    echo "Mail sent successfully.";
} catch (Exception $e) {
    echo "Mailer Error: {$mail->ErrorInfo}";
}
>