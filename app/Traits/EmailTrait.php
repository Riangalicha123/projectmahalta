<?php namespace App\Traits;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Config\Services;

trait EmailTrait {
    public function sendEmail($to, $subject, $message) {

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com"; // Use your SMTP host
            $mail->SMTPAuth = true;
            $mail->Username = 'mimong241@gmail.com';
            $mail->Password = 'lbtx jaes xlnn etqh';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Encryption - ssl or tls
            $mail->Port = 587; // TCP port to connect to

            // Recipients
            $mail->setFrom('mahaltaweb@gmail.com', 'Mahalta_Mailer');
            $mail->addAddress($to); // Add a recipient, passed via method parameter

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = $subject; // Use the $subject parameter
            $mail->Body = $message; // Use the $message parameter

            $mail->send();
            return true; // Return true on success
        } catch (Exception $e) {
            log_message('error', 'Mailer Error: ' . $mail->ErrorInfo); // Log error instead of printing
            return false; // Return false on error
        }
    }
}
