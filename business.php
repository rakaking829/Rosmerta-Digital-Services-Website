<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// === Get form data ===
$name  = $_POST['Name'] ?? '';
$email = $_POST['Email'] ?? '';  // <-- User's email
$phone = $_POST['Phone'] ?? ''; // <-- User's phone
$message = $_POST['Message'] ?? '';       
$captcha_input = $_POST['captcha'] ?? '';

// === CAPTCHA Validation ===
if (!isset($_SESSION['captcha']) || strtolower($captcha_input) !== strtolower($_SESSION['captcha'])) {
    die("Captcha incorrect. Please go back and try again.");
}

$mail = new PHPMailer(true);

try {
    // === SMTP Settings ===
    $mail->isSMTP();
    $mail->Host       = 'smtp.office365.com'; // Replace with your SMTP host
    $mail->SMTPAuth   = true;
    $mail->Username   = 'noreply.web@rosmertatech.com';   // SMTP username
    $mail->Password   = 'L$826992633603ak';              // SMTP password
    $mail->SMTPSecure = 'tls';                          // Encryption (tls or ssl)
    $mail->Port       = 587;                           // TCP port (587 for TLS, 465 for SSL)

    // === Sender & Recipient ===
    $mail->setFrom('noreply.web@rosmertatech.com', '');
    $mail->addAddress('connect@rosmertadigital.com', ''); // Optional
    // $mail->addBCC('support@smartech.co.in', '');         // Optional

    // === Attachment Validation ===
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === 0) {
        $fileTmpPath = $_FILES['attachment']['tmp_name'];
        $fileName    = $_FILES['attachment']['name'];
        $fileType    = mime_content_type($fileTmpPath);
        $fileSize    = $_FILES['attachment']['size'];

        $allowedTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'image/jpeg',
            'image/png'
        ];

        if ($fileSize > 5 * 1024 * 1024) {
            throw new Exception("File too large. Maximum size is 5MB.");
        }

        if (!in_array($fileType, $allowedTypes)) {
            throw new Exception("Error - Incorrect File Type. Only PDF, Word, JPG, and PNG are allowed.");
        }

        $mail->addAttachment($fileTmpPath, $fileName);
    }

    // === Email Content ===
    $mail->isHTML(true);
    $mail->Subject = 'RDS - Business Enquiries';
    $mail->Body    = "
        <table border='0' cellpadding='5' cellspacing='0'>
            <tr><td><strong>Name:</strong></td><td>{$name}</td></tr>
            <tr><td><strong>Email:</strong></td><td>{$email}</td></tr>
            <tr><td><strong>Phone No.:</strong></td><td>{$phone}</td></tr>
            <tr><td><strong>Your Message:</strong></td><td>{$message}</td></tr>
           
        </table>";
        
    $mail->AltBody = "Name: $name\nEmail: $email\nPhone No.: $phone\nYour Message: $message";

    // === Send Email ===
    $mail->send();

    header("Location: thankyou.html");
    exit();

} catch (Exception $e) {
    echo "Message could not be sent.<br>";
    echo "Mailer Error: {$mail->ErrorInfo}<br>";
    echo "Exception: " . $e->getMessage();
}
