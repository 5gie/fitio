<?php

namespace app\system\helpers;

use app\config\MailConfig;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail extends MailConfig
{

    private string $from;
    private string $to;
    private string $header;
    private string $body;
    private string $body2;

    public function __construct($from, $to, $header, $body, $body2 = ''){

        $this->from = $from;
        $this->to = $to;
        $this->header = $header;
        $this->body = $body;
        $this->body2 = $body2;

    }

    public function send()
    {

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = $this->host;                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = $this->username;                     // SMTP username
            $mail->Password   = 'secret';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom($this->from);
            $mail->addAddress($this->to);     // Add a recipient
            $mail->addReplyTo($this->from);
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            // Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $this->header;
            $mail->Body    = $this->body;
            $mail->AltBody = $this->body2;

            $mail->send();
            
            return true;

        } catch (Exception $e) {
            
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

            return false;
            
        }

    }
}