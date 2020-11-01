<?php

include 'redirect.php';
include 'config.php'

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->isHTML(true);
    $mail->Username = userMail;
    $mail->Password = passMail;
    $mail->From = userMail;
    $mail->FromName = $_POST['c-email'];
    $mail->Subject = $_POST['c-subject'];
    $mail->Body = 'De: ' . $_POST['c-email'] . '<br><br>' . $_POST['c-content'];
    $mail->addAddress(userMail);
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'The email message was sent.';
    }
    index(3000);
}