<?php

namespace App\Controller\Admin\Crud;

use App\Controller\Admin\Crud\Field\Field;
use App\Entity\Location;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class LocationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Location::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield Field::new('name');
        yield ChoiceField::new('type')
            ->renderAsNativeWidget()
            ->setChoices(array_combine(Location::TYPES(),Location::TYPES()))
            ->onlyOnForms()
            ->setFormTypeOption(
                'disabled',
                'disabled'
            )
            ->setFormTypeOption(
                'row_attr.style',
                'display:none;'
            )
        ;
        // use for Event Location CRUD
//        yield Field::new('events');
        // use for Launch Point CRUD
//        yield Field::new('launchPointEvents');

        yield AssociationField::new('eventAttendees', 'LifeTime Attendees')
            ->hideOnForm()
        ;

        //address fields
        yield Field::new('line1', 'Address Line 1')
            ->hideOnIndex()
        ;
        yield Field::new('line2', 'Address Line 2')
            ->hideOnIndex()
        ;
        yield Field::new('city')
            ->hideOnIndex()
        ;
        yield Field::new('state')
            ->hideOnIndex()
        ;
        yield Field::new('zipcode')
            ->hideOnIndex()
        ;
        yield Field::new('country')
            ->hideOnIndex()
        ;
    }
}
