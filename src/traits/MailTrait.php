<?php

namespace App\traits;

use Exception;
use SendGrid;
use SendGrid\Mail\Mail;

trait MailTrait
{

    public function sendMail(string $subject, string $to, string $content)
    {
        $email = new Mail;
        $email->setFrom($_ENV['SENDGRID_DEFAULT_SENDER_ADDRESS'], $_ENV['SENDGRID_DEFAULT_SENDER_NAME']);
        $email->setSubject($subject);
        $email->addTo($to);
        $email->addContent(
            "text/html",
            $content
        );
        $sendgrid = new SendGrid($_ENV['SENDGRID_API_KEY']);
        try {
            $response = $sendgrid->send($email);
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
    }
}
