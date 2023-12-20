<?php

namespace App\Tests;

use App\Controller\Admin\Crud\EventCrudController;
use App\Controller\Admin\Crud\EventLocationCrudController;
use App\Controller\Admin\Crud\LaunchPointCrudController;
use App\Controller\Admin\Crud\LeaderCrudController;
use App\Controller\Admin\Crud\TestimonialCrudController;
use App\Controller\Admin\MainDashboardController;
use App\Entity\Leader;
use Codeception\Attribute\Given;
use Codeception\Attribute\Then;
use Codeception\Attribute\When;
use Codeception\Exception\TestRuntimeException;
use EasyCorp\Bundle\EasyAdminBundle\Test\Trait\CrudTestIndexAsserts;
use EasyCorp\Bundle\EasyAdminBundle\Test\Trait\CrudTestSelectors;
use Zenstruck\Foundry\Test\Factories;

/**
 * Inherited Methods.
 *
 * @method void                    wantToTest($text)
 * @method void                    wantTo($text)
 * @method void                    execute($callable)
 * @method void                    expectTo($prediction)
 * @method void                    expect($prediction)
 * @method void                    amGoingTo($argumentation)
 * @method void                    am($role)
 * @method void                    lookForwardTo($achieveValue)
 * @method void                    comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class FunctionalTester extends \Codeception\Actor
{
    use _generated\FunctionalTesterActions;

    // Database Setup
    use Factories;

    // Easy Admin Selectors
    use CrudTestSelectors;
    use CrudTestIndexAsserts;

    /**
     * @Given /^I am logged in as a Leader$/
     */
    public function iAmLoggedInAsALeader()
    {
        $this->amOnPage('/login');
        $this->seeElement('form');
        $this->submitForm('form', [
                'email' => 'dev@dev.com',
                'password' => 'tada',
            ],
            'button[type="submit"]'
        );

        $this->seeCurrentUrlEquals('/admin');
    }

    /**
     * @Then /^I should not see a[n]? "([^"]*)" action?$/
     */
    public function iShouldNotSeeAnAction($action)
    {
        $this->dontSeeElement($this->getActionSelector('delete'));
    }

    /**
     * @Given /^I am on the "([^"]*)" "([^"]*)" Page$/
     */
    public function iAmOnTheAdminPage($objectType, $page)
    {
        // Go to the list page before going to the details page
        $this->iAmOnTheListPage($objectType);

        if (in_array(strtolower($page), ['detail', 'details'])) {
            $this->iAmOnTheDetailPage($objectType);
        }
    }

    protected function iAmOnTheListPage($objectType)
    {
        match ($objectType) {
            'Events' => $this->amOnAdminIndexPageFor(
                MainDashboardController::class,
                EventCrudController::class
            ),
            'Event Locations' => $this->amOnAdminIndexPageFor(
                MainDashboardController::class,
                EventLocationCrudController::class
            ),
            'Launch Points' => $this->amOnAdminIndexPageFor(
                MainDashboardController::class,
                LaunchPointCrudController::class
            ),
            'Testimonies' => $this->amOnAdminIndexPageFor(
                MainDashboardController::class,
                TestimonialCrudController::class
            ),
            'Leaders' => $this->amOnAdminIndexPageFor(
                MainDashboardController::class,
                LeaderCrudController::class
            ),
            default => throw new TestRuntimeException(sprintf('No object called %s, found in an Admin page.', $objectType))
        };

        $this->seeInCurrentUrl('crudAction=index');
    }

    /**
     * @When /^I click on the action menu for a[n]? "([^"]*)"$/
     */
    public function iClickOnTheActionMenuForAn($objectType)
    {
        $this->click('a[data-bs-toggle="dropdown"]', 'tbody tr:nth-child(1)');
    }

    protected function iAmOnTheDetailPage($objectType)
    {
        match ($objectType) {
            'Events' => $this->amOnAdminDetailPageFor(
                MainDashboardController::class,
                EventCrudController::class,
                $this->findFirstEntityId()
            ),
            'Event Locations' => $this->amOnAdminDetailPageFor(
                MainDashboardController::class,
                EventLocationCrudController::class,
                $this->findFirstEntityId()
            ),
            'Launch Points' => $this->amOnAdminDetailPageFor(
                MainDashboardController::class,
                LaunchPointCrudController::class,
                $this->findFirstEntityId()
            ),
            'Testimonies' => $this->amOnAdminDetailPageFor(
                MainDashboardController::class,
                TestimonialCrudController::class,
                $this->findFirstEntityId()
            ),
            'Leaders' => $this->amOnAdminDetailPageFor(
                MainDashboardController::class,
                LeaderCrudController::class,
                $this->findFirstEntityId()
            ),
            default => throw new TestRuntimeException(sprintf('No object called %s, found in an Admin page.', $objectType))
        };

        $this->seeInCurrentUrl('crudAction=detail');
    }
}
