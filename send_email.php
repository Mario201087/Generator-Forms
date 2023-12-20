<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

// Initialize PHPMailer
$mail = new PHPMailer(true);

// Server settings
$mail->isSMTP();
$mail->Host       = 'smtp.o2.pl';  // Update with your SMTP server
$mail->SMTPAuth   = true;
$mail->Username   = 'mariusz201087@o2.pl';  // Update with your SMTP username
$mail->Password   = 'Agata201087Mariusz';  // Update with your SMTP password
$mail->SMTPSecure = 'ssl';  // Use 'tls' or 'ssl' based on your server configuration
$mail->Port       = 465;  // Update with your SMTP port

// Sender
$mail->setFrom('your_email@o2.pl', 'Your Name');  // Use the same address as SMTP authentication

// Recipient (hardcoded for demonstration)
$recipient = 'mariusz201087@tlen.pl';  // Update with the actual recipient email address
$mail->addAddress($recipient, 'Recipient Name');

// Content
$mail->isHTML(true);
$mail->Subject = 'Form Submission';

// Hardcoded message for demonstration
$emailContent = 'This is a test message.';

$mail->Body = $emailContent;

try {
    // Send email
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
