<?php


namespace App\Service;


use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;


class Mailer
{
    private $mailer;

    private $from;

    public function __construct(MailerInterface $mailer, $from)
    {
        $this->mailer = $mailer;

    }


    public function sendMail($subject, $to, $view, $variables)
    {

        if(!filter_var($to, FILTER_VALIDATE_EMAIL)){
            return 'failed';
        }

        $email = (new TemplatedEmail())
            ->from($this->from)
            ->to($to)
            ->subject($subject)
            ->htmlTemplate("emails/".$view.".html.twig")
            ->context(['data' => $variables]);

        try {
            $this->mailer->send($email);
            return 'success';
        } catch(TransportExceptionInterface $e){
            return 'failed avec message :'.$e->getMessage();
        }


    }

}