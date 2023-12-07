<?php

namespace App\traits;

use Exception;
use SendGrid;
use SendGrid\Mail\Mail;

trait MailTrait
{

    public function sendMail(string $from, string $subject, string $to, string $name, string $content)
    {
        $email = new Mail;
        $email->setFrom($from, $name);
        $email->setSubject($subject);
        $email->addTo($to);
        $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
        $email->addContent(
            "text/html",
            "<strong>and easy to do anywhere, even with PHP</strong>"
        );
        $sendgrid = new SendGrid($_ENV['SENDGRID_API_KEY']);
        try {
            $response = $sendgrid->send($email);
            var_dump($response);
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
    }
}
