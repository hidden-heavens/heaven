<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php'; // Corrected path to autoload.php

function sendVerificationEmail($email, $username, $token) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io'; // Use Mailtrap for testing or replace with your SMTP provider
        $mail->SMTPAuth = true;
        $mail->Username = 'acf41252680927'; // Replace with your Mailtrap username
        $mail->Password = '70c38fe306a8ca'; // Replace with your Mailtrap password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 2525;

        $mail->setFrom('no-reply@hiddenheavens.com', 'Hidden Heavens');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Verify Your Email Address';
        $mail->Body = "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f9;
                    margin: 0;
                    padding: 0;
                    color: #333333;
                }
                .email-container {
                    max-width: 600px;
                    margin: 20px auto;
                    background-color: #ffffff;
                    border: 1px solid #dddddd;
                    border-radius: 8px;
                    overflow: hidden;
                }
                .email-header {
                    background-color: #4CAF50;
                    padding: 20px;
                    text-align: center;
                }
                .email-header img {
                    max-width: 100px;
                }
                .email-header h1 {
                    color: #ffffff;
                    margin: 0;
                    font-size: 24px;
                }
                .email-body {
                    padding: 20px;
                }
                .email-body p {
                    line-height: 1.6;
                    margin: 0 0 15px;
                }
                .email-button {
                    display: inline-block;
                    padding: 10px 20px;
                    background-color: #4CAF50;
                    color: #ffffff;
                    text-decoration: none;
                    border-radius: 4px;
                    margin-top: 20px;
                    font-size: 16px;
                }
                .email-footer {
                    text-align: center;
                    padding: 15px;
                    font-size: 12px;
                    color: #777777;
                    background-color: #f4f4f9;
                    border-top: 1px solid #dddddd;
                }
                .email-footer a {
                    color: #4CAF50;
                    text-decoration: none;
                }
            </style>
        </head>
        <body>
            <div class='email-container'>
                <!-- Header -->
                <div class='email-header'>
                    <img src='https://via.placeholder.com/100x50' alt='Company Logo'>
                    <h1>Welcome to Hidden Heavens!</h1>
                </div>
                <!-- Body -->
                <div class='email-body'>
                    <p>Hi $username,</p>
                    <p>Thank you for registering with <b>Hidden Heavens</b>. We’re thrilled to have you onboard!</p>
                    <p>To complete your registration, please verify your email address by clicking the button below:</p>
                    <p style='text-align: center;'>
                        <a href='http://localhost:8000/php/auth/verify.php?token=$token' class='email-button'>Verify My Email</a>
                    </p>
                    <p>If the button above does not work, copy and paste the following link into your browser:</p>
                    <p style='word-wrap: break-word; color: #4CAF50;'>
                        <a href='http://localhost:8000/php/auth/verify.php?token=$token'>http://localhost:8000/php/auth/verify.php?token=$token</a>
                    </p>
                    <p>If you did not create an account, you can safely ignore this email.</p>
                </div>
                <!-- Footer -->
                <div class='email-footer'>
                    <p>Need help? Visit our <a href='http://localhost:8000/help'>Help Center</a> or contact <a href='mailto:support@hiddenheavens.com'>support@hiddenheavens.com</a>.</p>
                    <p>&copy; " . date('Y') . " Hidden Heavens. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>
        ";
        

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}"); // Log the error
        return false;
    }
}
?>
