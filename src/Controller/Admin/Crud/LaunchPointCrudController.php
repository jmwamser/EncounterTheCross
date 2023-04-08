<?php
/**
 * @Author: jwamser
 * @CreateAt: 4/7/23
 * Project: EncounterTheCross
 * File Name: LaunchPointCrudController.php
 */

namespace App\Controller\Admin\Crud;

use App\Entity\Location;
use App\Repository\LocationRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;

class LaunchPointCrudController extends LocationCrudController
{
    public function createEntity(string $entityFqcn)
    {
        /** @var Location $entity */
        $entity = parent::createEntity($entityFqcn);

        $entity->setType(Location::TYPE_LAUNCH_POINT);

        return $entity;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setPageTitle(Crud::PAGE_INDEX, 'Launch Points');
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        LocationRepository::queryBuilderFilterByLocationType(Location::TYPE_LAUNCH_POINT, $qb);

        return $qb;
    }

}