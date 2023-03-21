<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Doctrine\ORM\Events;
class DoctrineSubscriber implements EventSubscriberInterface
{
    public function onPrePersist($event): void
    {
        dd($event);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            Events::prePersist => 'onPrePersist',
        ];
    }
}
