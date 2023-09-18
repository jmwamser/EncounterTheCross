<?php

namespace App\Controller\Admin\Crud;

use App\Controller\Admin\Crud\Field\Field;
use App\Entity\Event;
use App\Entity\Location;
use App\Repository\LocationRepository;
use App\Service\Exporter\XlsExporter;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Serializer\SerializerInterface;

class EventCrudController extends AbstractCrudController
{
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

        array_map(function(Location $launchPoint) use ($entity) {
            $entity->addLaunchPoint($launchPoint);
        }, $this->locationRepository->getAllActiveLaunchPoints());

        return $entity;
    }


    public function configureFields(string $pageName): iterable
    {
        // dynamic settings
        $location = AssociationField::new('location')
            ->setQueryBuilder(function(QueryBuilder $queryBuilder){
                LocationRepository::queryBuilderFilterByLocationType(Location::TYPE_EVENT, $queryBuilder);
            })
        ;
        if ($pageName !== Crud::PAGE_NEW) {
            $location
                ->autocomplete()
                ->setCrudController(EventLocationCrudController::class)
            ;
        } else {
            $location
                //TODO allow adding new locations on event creation
//                ->renderAsEmbeddedForm(LocationCrudController::class)
                ->setFormTypeOption(
                    'placeholder', 'Select Location Type',
                )
            ;
        }
        $launchPoints = AssociationField::new('launchPoints')
//            ->setFormType(ChoiceType::class)
            ->setQueryBuilder(function(QueryBuilder $queryBuilder){
                LocationRepository::queryBuilderFilterByLocationType(Location::TYPE_LAUNCH_POINT, $queryBuilder);
            })
        ;

        // return fields
        yield TextField::new('name');
        yield DateField::new('start');
        yield DateField::new('end')
            ->onlyOnForms();
        yield DateField::new( 'registrationDeadLineServers');
        yield $location;

        yield $launchPoints;
        yield MoneyField::new('price')
            ->setCurrency('USD');
        yield Field::new('TotalServers')
            ->hideOnForm();
        yield Field::new('TotalAttendees')
            ->hideOnForm();

    }

    public function configureActions(Actions $actions): Actions
    {
        $exportAction = Action::new('export_attending_list')
//            ->addCssClass('btn btn-success')
//            ->setIcon('fa fa-check-circle')
//            ->displayAsButton()
            ->linkToCrudAction('export')
        ;

        return parent::configureActions($actions)
            ->add(Crud::PAGE_INDEX,$exportAction);
    }

    public function export(AdminContext $adminContext, XlsExporter $exporter)
    {
        $event = $adminContext->getEntity()->getInstance();
        if (!$event instanceof Event) {
            throw new \LogicException('Entity is missing or not an Event');
        }

        return $exporter->createResponse($event->getEventParticipants()->toArray());
//        $spreadsheet = $spreadsheetGenerator->createSheet();

    }


}
