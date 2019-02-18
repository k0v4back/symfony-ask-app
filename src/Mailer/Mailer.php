<?php

namespace App\Mailer;

use App\Entity\User;

class Mailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var string
     */
    private $mailerFrom;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig, string $mailerFrom)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->mailerFrom = $mailerFrom;
    }

    public function sendConfirmationEmail(User $user)
    {
        $body = $this->twig->render('email/registration.html.twig', [
                'user' => $user
            ]
        );

        \Swift_Preferences::getInstance()->setCharset('utf-8');


        $message = (new \Swift_Message())
            ->setSubject('Добро пожаловать на сайт!')
            ->setFrom($this->mailerFrom)
            ->setTo($user->getEmail())
            ->setBody($body, 'text/html');
        $this->mailer->send($message);
    }
}