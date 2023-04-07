<?php

namespace App\EventSubscriber;

use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Doctrine\ORM\Events;
class DoctrineSubscriber implements EventSubscriberInterface
{
    public function onPrePersist(LifecycleEventArgs $event): void
    {
        //TODO add in RowPointer UUID so we dont have to generate it manually
        //TODO Remove manual UUID create in Factories for Fixtures, once done remove setRowPointer()

        dd($event);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            Events::prePersist => 'onPrePersist',
        ];
    }
}
