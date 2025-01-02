<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php'; // Ensure the correct path to autoload.php

// SMTP Configuration
$smtpHost = 'sandbox.smtp.mailtrap.io'; // Replace with your SMTP host
$smtpUsername = 'acf41252680927'; // Replace with your SMTP username
$smtpPassword = '70c38fe306a8ca'; // Replace with your SMTP password
$smtpPort = 587; // Use the appropriate port (e.g., 587 for STARTTLS, 465 for SSL)
$smtpSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use ENCRYPTION_STARTTLS for STARTTLS, PHPMailer::ENCRYPTION_SMTPS for SSL

// Email Details
$recipientEmail = 'victorymthombeni1@gmail.com'; // Replace with the recipient email
$recipientName = 'Test Recipient'; // Replace with the recipient name
$senderEmail = 'no-reply@hiddenheavens.com'; // Replace with the sender email
$senderName = 'Hidden Heavens'; // Replace with the sender name
$emailSubject = 'Test Email from PHPMailer';
$emailBody = 'This is a test email sent using PHPMailer.';

$mail = new PHPMailer(true);

try {
    // SMTP Configuration
    $mail->isSMTP();
    $mail->Host = $smtpHost;
    $mail->SMTPAuth = true;
    $mail->Username = $smtpUsername;
    $mail->Password = $smtpPassword;
    $mail->SMTPSecure = $smtpSecure;
    $mail->Port = $smtpPort;

    // Email Details
    $mail->setFrom($senderEmail, $senderName);
    $mail->addAddress($recipientEmail, $recipientName);

    $mail->isHTML(true);
    $mail->Subject = $emailSubject;
    $mail->Body = $emailBody;

    // Send the email
    if ($mail->send()) {
        echo 'Email sent successfully!';
    } else {
        echo 'Failed to send email.';
    }
} catch (Exception $e) {
    // Catch and display errors
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
?>
