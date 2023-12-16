<?php

namespace App\Tests;

use App\Entity\Leader;
use Codeception\Attribute\Given;
use Codeception\Attribute\Then;
use Codeception\Attribute\When;
use PHPUnit\Framework\IncompleteTestError;
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

    use Factories;

    /**
     * @Given /^I am logged in as a Leader$/
     */
    public function iAmLoggedInAsALeader()
    {
        // TODO: abstract this out into a reusable method, Args would be email and pass
        $this->have(Leader::class, [
            'email' => 'dev@dev.com',
        ]);

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
    public function iShouldNotSeeAAction($action)
    {
        throw new IncompleteTestError();
    }

    /**
     * @Given /^I am on the "([^"]*)" List Page$/
     */
    public function iAmOnTheListPage($objectType)
    {
        throw new IncompleteTestError();
    }

    /**
     * @When /^I click on the action menu for a[n]? "([^"]*)"$/
     */
    public function iClickOnTheActionMenuForAn($objectType)
    {
        throw new IncompleteTestError();
    }
}
