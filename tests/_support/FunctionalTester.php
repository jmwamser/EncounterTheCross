<?php

namespace App\Tests;

use App\Controller\Admin\Crud\EventCrudController;
use App\Controller\Admin\Crud\EventLocationCrudController;
use App\Controller\Admin\Crud\EventParticipantCrudController;
use App\Controller\Admin\Crud\LaunchPointCrudController;
use App\Controller\Admin\Crud\LeaderCrudController;
use App\Controller\Admin\Crud\TestimonialCrudController;
use App\Controller\Admin\MainDashboardController;
use App\Entity\Leader;
use Codeception\Attribute\Given;
use Codeception\Attribute\Then;
use Codeception\Attribute\When;
use Codeception\Configuration;
use Codeception\Exception\TestRuntimeException;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
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
    public function iShouldNotSeeAnAction($action): void
    {
        $this->dontSeeElement($this->getActionSelector($action));
    }

    /**
     * @Then /^I should see a[n]? "([^"]*)" action?$/
     */
    public function iShouldSeeAnAction($action): void
    {
        $this->dontSeeElement($this->getActionSelector($action));
    }

    /**
     * @Given /^I am on the "([^"]*)" "([^"]*)" Page$/
     */
    public function iAmOnTheAdminPage($objectType, $page)
    {
        // TODO: This will need adjusted for the other admin pages as well

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
     * @When /^I click on the action row menu$/
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

    /**
     * @Given /^I see "([^"]*)" action$/
     */
    public function iSeeAction($action)
    {
        $this->seeElement($this->getActionSelector(
            self::createActionClass($action)
        ));
    }

    /**
     * @When /^I click and download the "([^"]*)" action$/
     */
    public function iClickAndDownloadTheAction($action)
    {
        $this->receiveFileResponse($this->getActionSelector(
            self::createActionClass($action)
        ));
    }

    /**
     * @When /^I click the "([^"]*)" action$/
     */
    public function iClickTheAction($action)
    {
        $this->click($this->getActionSelector(
            self::createActionClass($action)
        ));
    }

    /**
     * @Then /^I receive the xlsx file$/
     */
    public function iReceiveTheXlsxFile()
    {
        $this->seeFileFound('Export.xlsx', Configuration::outputDir());
    }

    /**
     * @Given /^I verify there are tabs$/
     */
    public function iVerifyThereAreTabs()
    {
        $sheetCount = $this->getSpreedSheetTabCount('Export.xlsx');

        $this->assertGreaterThan(1, $sheetCount);
        $this->deleteExportFile('Export.xlsx');
    }

    /**
     * @Given /^I verify there are not tabs$/
     */
    public function iVerifyThereAreNotTabs()
    {
        $sheetCount = $this->getSpreedSheetTabCount('Export.xlsx');

        $this->assertLessOrEquals(1, $sheetCount);
        $this->deleteExportFile('Export.xlsx');
    }

    private static function createActionClass($action)
    {
        return strtolower(str_replace(' ', '_', $action));
    }

    /**
     * @Then /^I should see Form Field label of "([^"]*)"$/
     */
    public function iShouldSeeFormFieldDisplayOf($fieldLabel)
    {
        $this->see($fieldLabel);
    }

    /**
     * @Then /^I should be on "([^"]*)" "([^"]*)" Page$/
     */
    public function iShouldBeOnPage($entityCrud, $page)
    {
        $crudActionPart = 'crudAction=';
        $crudActionPart .= match (strtolower($page)) {
            'list' => Crud::PAGE_INDEX,
            'show' => Crud::PAGE_DETAIL,
            'edit' => Crud::PAGE_EDIT,
            'new' => Crud::PAGE_NEW,

            default => $this->fail('Not able to verifiy all the options'),
        };

        $this->seeInCurrentUrl($crudActionPart);

        // crudControllerFqcn=App%5CController%5CAdmin%5CCrud%5CEventParticipantCrudController
        $crudControllerPart = 'crudControllerFqcn=';
        $crudControllerPartClass = match ($entityCrud) {
            'Events' => EventCrudController::class,
            'Event Participants' => EventParticipantCrudController::class,
            'Leaders' => LeaderCrudController::class,
            'Launch Points' => LaunchPointCrudController::class,
            default => $this->fail('Not able to identify the Entity for the CRUD.')
        };

        $this->seeInCurrentUrl($crudControllerPart.urlencode($crudControllerPartClass));
    }
}
