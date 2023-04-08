<?php

namespace App\Controller\Admin\Crud;

use App\Entity\Leader;

class LeaderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Leader::class;
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
