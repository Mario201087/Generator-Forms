<?php
<<<<<<< HEAD
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
=======
require __DIR__ . '/vendor/autoload.php';  // Make sure to include the Twilio PHP library

use Twilio\Rest\Client;

// Check if the form was submitted and if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $toPhoneNumber = $_POST['recipient']; // Assuming the phone number is passed as "recipient"
    $messageBody = $_POST['content']; // Assuming the message body is passed as "content"

    // Your Twilio credentials
    $accountSid = 'AC79738bf14525ae339c9f2d5e70fee564';  // Replace with your Twilio Account SID
    $authToken  = 'c8f5cb9191c6b40da9dabdb2415ac5dc';  // Replace with your Twilio Auth Token
    $twilio = new Client($accountSid, $authToken);

    // Update with your actual Twilio phone number
    $fromPhoneNumber = "+12407880303";

    // Send SMS message
    try {
        $twilio->messages->create(
            $toPhoneNumber,
            [
                "body" => $messageBody,
                "from" => $fromPhoneNumber
            ]
        );
        echo 'SMS has been sent';
    } catch (Exception $e) {
        echo "SMS could not be sent. Twilio Error: {$e->getMessage()}";
    }
} else {
    echo "Invalid request method.";
}
?>
>>>>>>> 8b042ad (Commit message describing your changes)
