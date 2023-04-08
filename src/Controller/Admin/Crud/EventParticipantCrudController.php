<?php

namespace App\Controller\Admin\Crud;

use App\Entity\EventParticipant;

class EventParticipantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EventParticipant::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
