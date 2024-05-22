<?php

namespace App\Controller\Admin\Crud;

use App\Controller\Admin\Crud\Extended\ParentCrudControllerInterface;
use App\Controller\Admin\Crud\Extended\ParentCrudTrait;
use App\Controller\Admin\Crud\Field\Field;
use App\Entity\Embeddable\TrainingModal;
use App\Entity\Event;
use App\Entity\Location;
use App\Enum\EventParticipantStatusEnum;
use App\Repository\LocationRepository;
use App\Service\Exporter\XlsExporter;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use LogicException;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EventCrudController extends AbstractCrudController implements ParentCrudControllerInterface
{
    use ParentCrudTrait;

    private LocationRepository $locationRepository;

    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function createEntity(string $entityFqcn)
    {
        /** @var Event $entity */
        $entity = parent::createEntity($entityFqcn);

        array_map(function (Location $launchPoint) use ($entity) {
            $entity->addLaunchPoint($launchPoint);
        }, $this->locationRepository->getAllActiveLaunchPoints());

        return $entity;
    }

    public function configureFields(string $pageName): iterable
    {
        // dynamic settings
        $location = AssociationField::new('location')
            ->setQueryBuilder(function (QueryBuilder $queryBuilder) {
                LocationRepository::queryBuilderFilterByLocationType(Location::TYPE_EVENT, $queryBuilder);
            })
        ;
        if (Crud::PAGE_NEW !== $pageName) {
            $location
                ->autocomplete()
                ->setCrudController(EventLocationCrudController::class)
            ;
        } else {
            $location
                // TODO allow adding new locations on event creation
//                ->renderAsEmbeddedForm(LocationCrudController::class)
                ->setFormTypeOption(
                    'placeholder', 'Select Location Type',
                )
            ;
        }
        $launchPoints = AssociationField::new('launchPoints')
//            ->setFormType(ChoiceType::class)
            ->autocomplete()
            ->setQueryBuilder(function (QueryBuilder $queryBuilder) {
                LocationRepository::queryBuilderFilterByLocationType(Location::TYPE_LAUNCH_POINT, $queryBuilder);
            })
        ;

        // return fields
        yield FormField::addFieldset('Encounter Details')->collapsible();
        yield TextField::new('name');
        yield DateField::new('start');
        yield DateField::new('end')
            ->onlyOnForms();
        yield DateField::new('registrationDeadLineServers');

        yield FormField::addFieldset('Launches & Costs')->collapsible();
        yield $location;

        yield $launchPoints;
        yield MoneyField::new('price')
            ->setStoredAsCents(false)
            ->setCurrency('USD');
        yield Field::new('TotalServers')
            ->hideOnForm();
        yield Field::new('TotalAttendees')
            ->hideOnForm();

        yield FormField::addFieldset('Server Training Information')->collapsible();
        yield Field::new('training.locationName')
            ->setLabel('Place')
            ->setHelp('Required value before added to Server Thank You Email.')
            ->hideOnIndex()
        ;
        yield Field::new('training.locationAddress')
            ->setLabel('Address')
            ->hideOnIndex()
        ;
        yield Field::new('training.locationCity')
            ->setLabel('City')
            ->hideOnIndex()
        ;
        yield Field::new('training.locationState')
            ->setLabel('State')
            ->hideOnIndex()
        ;
        yield Field::new('training.locationZip')
            ->setLabel('Postal Code')
            ->hideOnIndex()
        ;
        yield DateField::new('training.startTime')
            ->setTimezone(TrainingModal::DEFAULT_VIEW_TIMEZONE)
            ->setLabel('Date')
            ->setHelp('Required value before added to Server Thank You Email.')
            ->hideOnIndex()
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        $exportByLaunchAction = Action::new('export_attending_by_launch')
//            ->addCssClass('btn btn-success')
//            ->setIcon('fa fa-check-circle')
//            ->displayAsButton()
            ->linkToCrudAction('export')
        ;

        $exportAllAction = Action::new('export_all_attending')
            ->linkToCrudAction('exportAll')
        ;

        $registrations = Action::new('show_registrations')
            ->linkToCrudAction('redirectToShowSubCrud')
        ;

        return parent::configureActions($actions)
            ->add(Crud::PAGE_INDEX, $exportByLaunchAction)
            ->add(Crud::PAGE_INDEX, $exportAllAction)
            ->add(Crud::PAGE_INDEX, $registrations)
            ->add(Crud::PAGE_DETAIL, $registrations)
            ->disable(Action::DELETE, Action::BATCH_DELETE)
        ;
    }

    public function exportAll(AdminContext $adminContext, XlsExporter $exporter): StreamedResponse
    {
        $event = $adminContext->getEntity()->getInstance();
        if (!$event instanceof Event) {
            throw new LogicException('Entity is missing or not an Event');
        }

        $spreadsheet = $exporter->createEventReport(
            array_values($event->getEventParticipants(
                EventParticipantStatusEnum::ATTENDING
            )->toArray())
        );

        return $exporter->streamResponse($spreadsheet);
    }

    public function export(AdminContext $adminContext, XlsExporter $exporter): StreamedResponse
    {
        $event = $adminContext->getEntity()->getInstance();
        if (!$event instanceof Event) {
            throw new LogicException('Entity is missing or not an Event');
        }

        $spreadsheet = $exporter->createEventReportByLaunchPoint(
            $event->getEventParticipants(
                EventParticipantStatusEnum::ATTENDING
            )->toArray()
        );

        return $exporter->streamResponse($spreadsheet);
    }

    protected function getSubCrudControllerClass(): string
    {
        return EventParticipantCrudController::class;
    }
}
