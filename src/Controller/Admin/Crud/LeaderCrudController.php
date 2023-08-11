<?php

namespace App\Controller\Admin\Crud;

use App\Controller\Admin\Crud\Field\Field;
use App\Entity\Leader;
use App\Service\RoleManager\Role;
use App\Service\RoleManager\RoleFormatter;
use App\Service\RoleManager\RoleListFinder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;

class LeaderCrudController extends AbstractCrudController
{
    private RoleHierarchyInterface $roleHierarchy;
    private RoleListFinder $roleFinder;

    public function __construct(RoleHierarchyInterface $roleHierarchy,RoleListFinder $roleFinder)
    {
        $this->roleHierarchy = $roleHierarchy;
        $this->roleFinder = $roleFinder;
    }
    public static function getEntityFqcn(): string
    {
        return Leader::class;
    }

    public function configureFields(string $pageName): iterable
    {
//        yield from parent::configureFields($pageName);
        yield AssociationField::new('person','Full Name')
            ->renderAsEmbeddedForm(PersonCrudController::class)
        ;
        yield EmailField::new('email');
        yield DateField::new('updatedAt')
            ->hideOnForm();
        yield DateField::new('createdAt')
            ->onlyOnDetail();

        /*
         * How we want to display the options list for roles
         *
         * !!!If Role::ADMIN is not the role right under Role::SUPER_ADMIN we will want to redo this logic!!!
         *
         * New -> ROLE::FULL = that and down , Role::LIMITED_FULL = that and down
         * Index -> only what is assigned
         * Edit -> ROLE::FULL = that and down , Role::LIMITED_FULL = that and down
         * Details -> only what is assigned
         *
         * This list is to determine what roles the current user can assign to the current Leader Object
         * Default List = $securityUserRoles
         */
        $roles = $pageName === Crud::PAGE_NEW || $pageName === Crud::PAGE_EDIT ?
            $this->roleFinder->getRolesAccessableToUserOrFullList($this->getUser())// is either and ADMIN or SUPER_ADMIN
            : $this->getInstancesRoles();
        yield ChoiceField::new('roles')
            ->setChoices(
                RoleFormatter::formatRolesForForm($roles)
            )
            ->allowMultipleChoices()
            ->renderExpanded()
            ->renderAsBadges()
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)
            //TODO: Add invitation Action for new Leaders
            ->remove(Crud::PAGE_INDEX,Crud::PAGE_NEW);
    }


    /**
     * Use this to get Full list if editing, or assigned list if displaying
     *
     * @return array
     */
    private function getInstancesRoles(): array
    {
        // Get Leaders roles if instance is not null,
        // should only be null if instance was never created before.
        // Null would be edge case and I can say for now defaulting this to a
        // normal admin here would be fine. May change later
        $instanceRoles = $this->getContext()->getEntity()->getInstance()?->getRoles();

        // if instance was null then return Role set to a User with no assigned roles
        return $instanceRoles ?? [Role::USER];
    }
}
