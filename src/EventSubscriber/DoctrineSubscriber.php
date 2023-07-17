<?php

namespace App\EventSubscriber;

use App\Entity\Traits\CoreEntityTrait;
use App\Service\UuidManager\UuidFactory;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;

use Doctrine\ORM\Events;
class DoctrineSubscriber implements EventSubscriberInterface
{

    public function prePersist(PrePersistEventArgs $event): void
    {
        //TODO add in RowPointer UUID so we dont have to generate it manually
        //TODO Remove manual UUID create in Factories for Fixtures, once done remove setRowPointer()

        $object = $event->getObject();

        if(!in_array(CoreEntityTrait::class, class_uses($object), true)) {
            return;
        }

        if (null !== $object->getRowPointer()) {
            return;
        }

        $object->setRowPointer(UuidFactory::newUuid());
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
        ];
    }
}
