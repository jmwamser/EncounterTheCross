<?php

namespace App\Tests\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use App\DataFixtures\AppFixtures;
use Codeception\Module\Symfony;
use Codeception\TestInterface;
use Codeception\Util\Locator;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGeneratorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Test\Trait\CrudTestActions;
use EasyCorp\Bundle\EasyAdminBundle\Test\Trait\CrudTestFormAsserts;
use EasyCorp\Bundle\EasyAdminBundle\Test\Trait\CrudTestIndexAsserts;
use EasyCorp\Bundle\EasyAdminBundle\Test\Trait\CrudTestUrlGeneration;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\DomCrawler\Crawler;
use Zenstruck\Foundry\Test\Factories;

class Functional extends \Codeception\Module
{
    // Easy Admin TestHelpers
    use CrudTestActions;
    use CrudTestIndexAsserts;
    use CrudTestUrlGeneration;

    // Easy Admin Assert Helpers
    use CrudTestIndexAsserts;
    use CrudTestFormAsserts;

    // Database Factories
    use Symfony\DoctrineAssertionsTrait;

    //    protected KernelBrowser $client;

    protected AdminUrlGeneratorInterface $adminUrlGenerator;
    protected EntityManagerInterface $entityManager;

    public function _beforeSuite(array $settings = [])
    {
        parent::_beforeSuite($settings);

        $this->getModule('Doctrine2')->loadFixtures(AppFixtures::class, false);
    }

    public function _before(TestInterface $test)
    {
        parent::_before($test);
        /** @var Symfony $symfony */
        $symfony = $this->getModule('Symfony');
        if ($symfony->_getContainer()->has(AdminUrlGenerator::class)) {
            $this->adminUrlGenerator = $symfony->_getContainer()->get(AdminUrlGenerator::class);
        }
    }

    public function findFirstEntityId()
    {
        /** @var Symfony $symfony */
        $symfony = $this->getModule('Symfony');

        /** @var Crawler $table */
        $table = $symfony->_findElements(Locator::firstElement('//table'));
        //        $this->assertNotEmpty($tableBody);
        //        $table = reset($tableBody);
        //        dump($tableBody);
        $this->assertEquals('table', $table->nodeName());
        $tableRow = $table->filter('tbody')->filter('tr');

        return $tableRow->attr('data-id');
    }

    // Index Generation
    public function amOnAdminIndexPageFor(string $dashboard, string $controller, string $query = null)
    {
        /** @var Symfony $symfony */
        $symfony = $this->getModule('Symfony');
        $symfony->amOnPage(
            $this->generateIndexUrl($query, $dashboard, $controller)
        );
        $symfony->seeResponseCodeIsSuccessful();
    }

    // New Form Generation
    public function amOnAdminNewFormPageFor(string $dashboard, string $controller, string $query = null)
    {
        /** @var Symfony $symfony */
        $symfony = $this->getModule('Symfony');
        $symfony->amOnPage(
            $this->generateNewFormUrl($query, $dashboard, $controller)
        );
        $symfony->seeResponseCodeIsSuccessful();
    }

    // Edit Form Generation
    public function amOnAdminEditFormPageFor(string $dashboard, string $controller, string $query = null)
    {
        /** @var Symfony $symfony */
        $symfony = $this->getModule('Symfony');
        $symfony->amOnPage(
            $this->generateEditFormUrl($query, $dashboard, $controller)
        );
        $symfony->seeResponseCodeIsSuccessful();
    }

    // Detail Generation
    public function amOnAdminDetailPageFor(string $dashboard, string $controller, string $query = null)
    {
        /** @var Symfony $symfony */
        $symfony = $this->getModule('Symfony');
        $symfony->amOnPage(
            $this->generateDetailUrl($query, $dashboard, $controller)
        );
        $symfony->seeResponseCodeIsSuccessful();
    }

    // Filter Render Generation
    public function amOnAdminFilterRenderPageFor(string $dashboard, string $controller)
    {
        /** @var Symfony $symfony */
        $symfony = $this->getModule('Symfony');
        $symfony->amOnPage(
            $this->generateFilterRenderUrl($dashboard, $controller)
        );
        $symfony->seeResponseCodeIsSuccessful();
    }

    // Crud Generation
    //    public function amOnCrudUrl(string $dashboard, string $controller,?string $query = null)
    //    {
    //        /** @var Symfony $symfony */
    //        $symfony = $this->getModule('Symfony');
    //        $symfony->amOnPage(
    //            $this->getCrudUrl($query,$dashboard,$controller)
    //        );
    //    }
}
