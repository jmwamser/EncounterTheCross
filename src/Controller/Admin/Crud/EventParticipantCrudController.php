<?php

namespace App\Controller\Admin\Crud;

use App\Controller\Admin\Crud\Extended\ParentCrudControllerInterface;
use App\Controller\Admin\Crud\Extended\SubCrudControllerInterface;
use App\Controller\Admin\Crud\Extended\SubCrudTrait;
use App\Entity\EventParticipant;
use App\Repository\EventParticipantRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EventParticipantCrudController extends AbstractCrudController implements SubCrudControllerInterface
{
    use SubCrudTrait;

    public static function getEntityFqcn(): string
    {
        return EventParticipant::class;
    }

    public static function getEntityRepositoryFqcn(): string
    {
        return EventParticipantRepository::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $detailIndexAction = Action::new(Action::INDEX, 'Back to Registrations')
            ->linkToUrl(function (EventParticipant $eventParticipant) {
                return $this->getAdminUrlGenerator()
                    ->includeReferrer()
                    ->set(ParentCrudControllerInterface::PARENT_ID, $eventParticipant->getEvent()->getId())
                    ->setController(EventParticipantCrudController::class)
                    ->setAction(Action::INDEX)
                    ->generateUrl()
                ;
            });

        return parent::configureActions($actions)
            ->remove(Crud::PAGE_DETAIL, Action::INDEX)
            ->add(Crud::PAGE_DETAIL, $detailIndexAction)
            ->disable(Action::DELETE, Action::BATCH_DELETE, Action::NEW)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('fullName'),
            Field::new('phone'),
            Field::new('email'),
            TextField::new('type'),
            AssociationField::new('event'),
            BooleanField::new('paid'),
        ];
    }
}
