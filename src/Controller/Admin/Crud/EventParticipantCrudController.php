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
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
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
            // Temp disable Edit, till we get the edit forms working correctly
            ->disable(Action::EDIT)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        /** @var ?EventParticipant $entity */
        $entity = $this->getContext()?->getEntity()->getInstance();

        // Core
        yield FormField::addColumn('col-lg-8');
        yield FormField::addFieldset('Participant Details');
        yield TextField::new('fullName')
            ->hideOnForm()
        ;
        yield TextField::new('person.firstName', 'First Name')
            ->hideOnIndex()
            ->hideOnDetail()
        ;
        yield TextField::new('person.lastName', 'Last Name')
            ->hideOnIndex()
            ->hideOnDetail()
        ;
        yield EmailField::new('person.email', 'Email')
            ->hideOnIndex()
        ;
        yield TelephoneField::new('person.phone', 'Phone')
            ->hideOnIndex()
        ;

        yield Field::new('line1', 'Address')
            ->hideOnIndex()
        ;
        yield Field::new('line2', 'Address 2')
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

        yield FormField::addFieldset('Important');
        yield Field::new('healthConcerns')
            ->hideOnIndex()
        ;
        yield Field::new('questionsOrComments')
            ->hideOnIndex()
        ;

        yield FormField::addColumn('col-lg-4');
        yield FormField::addFieldset('Additionals');
        yield TextField::new('status')
            ->hideOnForm()
            ->setLabel('Attending Status')
        ;
        yield TextField::new('type')
            ->hideOnForm()
        ;
        yield ChoiceField::new('type')
            ->setFormTypeOption(
                ChoiceField::OPTION_CHOICES,
                array_combine(
                    EventParticipant::TYPES(),
                    EventParticipant::TYPES()
                )
            )
            ->onlyOnForms()
        ;
        yield AssociationField::new('event');
        yield BooleanField::new('paid');
        yield TextField::new('paymentMethod')
            ->hideOnForm()
        ;
        yield ChoiceField::new('paymentMethod')
            ->setFormTypeOption(ChoiceField::OPTION_CHOICES, array_combine(
                ['Pay at the door', 'Apply for Scholarship'],
                EventParticipant::PAYMENT_METHODS
            ))
            ->onlyOnForms()
        ;
        yield AssociationField::new('launchPoint');

        // Attendee
        // TODO: Contact Person Lookup when edited...
        // TODO: Invited By Person Lookup??

        if ($entity && EventParticipant::TYPE_ATTENDEE === $entity->getType()) {
            yield FormField::addFieldset('Attendee Contact Details');
            yield Field::new('attendeeContactPerson.details', 'Contact Person')
                ->hideOnIndex()
            ;
            yield Field::new('attendeeContactPerson.relationship', 'Contact Relationship')
                ->hideOnIndex()
            ;
            yield TelephoneField::new('attendeeContactPerson.details.phone', 'Contact Phone')
                ->hideOnIndex()
            ;

            yield FormField::addFieldset('Attendee Details');
            yield Field::new('invitedBy')
                ->hideOnIndex()
            ;
            yield Field::new('church')
                ->hideOnIndex()
            ;
        }

        // Server
        if ($entity && EventParticipant::TYPE_SERVER === $entity->getType()) {
            yield FormField::addFieldset('Serving Details');
            yield Field::new('serverAttendedTimes')
                ->hideOnIndex()
            ;
        }
    }
}
