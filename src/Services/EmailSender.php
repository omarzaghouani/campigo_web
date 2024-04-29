<?php

namespace App\Services;

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Transport\Dsn;

class EmailSender
{
    public function sendEmail(string $to , string $subject , string $text)
    {
        // Create a Transport object
        $transport = Transport::fromDsn('smtp://omarzaghouani01@gmail.com:cpiw%20lhzs%20xwfk%20xixi@smtp.gmail.com:587');

        // Create a Mailer object
        $mailer = new Mailer($transport);

        // Create an Email object
        $email = (new Email())
            ->from('omarzaghouani01@gmail.com')
            ->to($to)
            ->subject($subject)
            ->text($text);

        // Send the email
        $mailer->send($email);
    }
}