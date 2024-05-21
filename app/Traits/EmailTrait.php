<?php

namespace App\Traits;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Config\Services;

trait EmailTrait
{
    public function sendEmail($to, $subject, $message, $attachmentPath = null)
    {

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com"; // Use your SMTP host
            $mail->SMTPAuth = true;
            $mail->Username = 'mahaltaresortsconventioncenter@gmail.com';
            $mail->Password = 'qplh vyeb vtbe rssk';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Encryption - ssl or tls
            $mail->Port = 587; // TCP port to connect to

            // Recipients
            $mail->setFrom('mahaltaweb@gmail.com', 'Mahalta_Mailer');
            $mail->addAddress($to); // Add a recipient, passed via method parameter
            // Add attachment if exists
            if ($attachmentPath && file_exists($attachmentPath)) {
                $cid = $mail->addEmbeddedImage($attachmentPath, 'qr-code-cid', 'QRCode.png');
                $message .= '<br><img src="cid:qr-code-cid">';
            } elseif ($attachmentPath) {
                log_message('error', "Attachment file does not exist: $attachmentPath");
                throw new Exception("Attachment file does not exist: $attachmentPath");
            }


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
