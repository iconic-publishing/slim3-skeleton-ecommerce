<?php

namespace Base\Services\PHPMailer;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use Base\Constructor\BaseConstructor;

class Email extends BaseConstructor {

    public function sned($email, $fullName, $subject, $body) {
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = $this->config->get('mail.host');
        $mail->SMTPAuth = true;
        $mail->Username = $this->config->get('mail.username');
        $mail->Password = $this->config->get('mail.password');
        $mail->SMTPSecure = $this->config->get('mail.encryption');
        $mail->Port = $this->config->get('mail.port');
        $mail->setFrom($this->config->get('mail.from.address'), $this->config->get('mail.from.name'));
        $mail->addAddress($email, $fullName);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = $body;
        $mail->send();

        return $mail;
    }

}