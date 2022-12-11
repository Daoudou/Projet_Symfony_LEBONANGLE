<?php

namespace App\EventListener;

use MailerService;

class MailingSubscriber implements EventSubscriberInterface
{
    
    public function __construct(private readonly
        MailerService $mailerService
    )
    {
        
    }

    public static function getSubscribedEvents(): array
    {
        return [MailerEvent::class => 'onLogout'];
    }

}
