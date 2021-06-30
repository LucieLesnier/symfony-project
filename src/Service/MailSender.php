<?php


namespace App\Service;


use App\Entity\Quack;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Message;

class MailSender
{

    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {

        $this->mailer = $mailer;

    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendNewModerationRequest(Quack $quack)
    {

        $email = (new Email())
            //->to($quack->getAuthor()->getEmail())
            ->to('lucie.lesnier@le-campus-numerique.fr')
            ->subject('YOU HAVE A BIG BIG PROBLEM DUCKYYYY')
            ->text('DUCK YOOOOUUUUU');


            return $this->mailer->send($email);

    }
}