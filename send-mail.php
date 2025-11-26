<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $walletName = isset($_POST["walletName"]) ? $_POST["walletName"] : "Unknown Wallet";
    $fullname   = isset($_POST["fullname"]) ? $_POST["fullname"] : "";
    $email      = isset($_POST["email"]) ? $_POST["email"] : "";
    $message    = isset($_POST["message"]) ? $_POST["message"] : "";

    $mail = new PHPMailer(true);

    try {
        // SMTP setup (Gmail)
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'support@official-songkang.com'; // change this
        $mail->Password = 'Songkang@1';   // change this
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Sender & recipient
        $mail->setFrom('support@official-songkang.com', 'AJ Digital');
        $mail->addAddress('ajdigital48@gmail.com', 'AJ Digital');

        // Add reply-to only if valid email
        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $mail->addReplyTo($email, $fullname);
        }

        // Email content
        $mail->isHTML(false);
        $mail->Subject = "New Wallet Form Submission - $walletName";
        $mail->Body = "You have a new submission:\n\n"
                    . "Wallet: $walletName\n"
                    . "Name: $fullname\n"
                    . "Email: $email\n"
                    . "Message: $message\n";

        $mail->send();

        // Redirect to thank-you page
        header("Location: message.html");
        exit();

    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}
?>
