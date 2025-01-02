<?php
require 'email_config.php'; // Include centralized email configuration

if (isset($_POST['action']) && $_POST['action'] === 'sendEmail') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Validate inputs
    $errors = [];
    if (empty($name)) $errors[] = 'Please enter your name.';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email address.';
    if (empty($subject)) $errors[] = 'Please enter a subject.';
    if (empty($message)) $errors[] = 'Please enter your message.';

    if (!empty($errors)) {
        echo '<div class="alert alert-danger">' . implode('<br>', $errors) . '</div>';
        exit;
    }

    try {
        // Get PHPMailer instance
        $mail = getMailer();

        // Recipient
        $mail->addAddress('your_email@example.com', 'Hidden Heavens Support'); // Replace with your receiving email

        // Email Content
        $mail->Subject = "Contact Us: $subject";
        $mail->isHTML(true);
        $mail->Body = "
            <h3>Contact Us Message</h3>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Message:</strong></p>
            <p>$message</p>
        ";

        // Send Email
        $mail->send();
        echo '<div class="alert alert-success">Thank you for contacting us. Your message has been successfully sent!</div>';
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Error: Unable to send your message. Please try again later.</div>';
        error_log('PHPMailer Error: ' . $e->getMessage());
    }
} else {
    echo '<div class="alert alert-danger">Invalid request.</div>';
}
?>
