<?php

use App\Entity\Advert;
use App\Repository\AdminUserRepository;
use App\Repository\AdvertRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Notifier\NotifierInterface;

class MailerService 
{

    public function __construct(private NotifierInterface $notifier,
    private AdminUserRepository $adminUserRepository,
    private MailerInterface $mailer)
    {
        
    }

    public function senMail(MailerInterface $mailerInterface, Advert $advert){
        
        $email = (new Email())
            ->from('admin@email.com')
            ->to('you@example.com')
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        //$mailer->send($email);
        $mailerInterface->send($email);

        // ...
    }



}
