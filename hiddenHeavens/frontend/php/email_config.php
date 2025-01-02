<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Ensure correct path to autoload.php

function getMailer() {
    $mail = new PHPMailer(true);
    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io'; // Use Mailtrap for testing or replace with your SMTP provider
        $mail->SMTPAuth = true;
        $mail->Username = 'acf41252680927'; // Replace with your Mailtrap username
        $mail->Password = '70c38fe306a8ca'; // Replace with your Mailtrap password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Default Sender
        $mail->setFrom('no-reply@hiddenheavens.com', 'Hidden Heavens');

        return $mail;
    } catch (Exception $e) {
        error_log('Error configuring PHPMailer: ' . $e->getMessage());
        throw $e;
    }
}
?>
