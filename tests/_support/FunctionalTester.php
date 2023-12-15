<?php

namespace App\Tests;

use Codeception\Attribute\Given;
use Codeception\Attribute\Then;
use Codeception\Attribute\When;
use PHPUnit\Framework\IncompleteTestError;

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

    /**
     * @Given /^I am logged in as a Leader$/
     */
    public function iAmLoggedInAsALeader()
    {
        throw new IncompleteTestError();
    }

    /**
     * @Then /^I should not see a "([^"]*)" action$/
     */
    public function iShouldNotSeeAAction($arg1)
    {
        throw new IncompleteTestError();
    }

    /**
     * @Given /^I am on the "([^"]*)" List Page$/
     */
    public function iAmOnTheListPage($arg1)
    {
        throw new IncompleteTestError();
    }

    /**
     * @When /^I click on the action menu for an "([^"]*)"$/
     */
    public function iClickOnTheActionMenuForAn($arg1)
    {
        throw new IncompleteTestError();
    }
}
