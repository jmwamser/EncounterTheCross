<?php

namespace App\Tests\Unit\Service;

use App\Entity\Person;
use App\Repository\PersonRepository;
use App\Service\PersonManager;
use App\Tests\UnitTester;

class PersonManagerTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testExistsSubmittingRealDuplicateOfSelfByEmail()
    {
        // ** Persons
        // Submitted via form
        $submittedPerson = $this->createSubmittedPerson();

        // ** Mocks
        $personRepo = $this->createMock(PersonRepository::class);
        $personRepo
            ->expects($this->exactly(1))
            ->method('findBy') // Need to use `findBy` not `findOneBy` as there could be dup'ed emails or phone numbers
            ->with([
                'email' => 'attending@attend.com',
            ])
            ->willReturn([$submittedPerson])
        ;

        $personManager = new PersonManager($personRepo);

        // ** Tests
        $managerAnswer = $personManager->exists($submittedPerson);

        $this->assertSamePersons($submittedPerson, $managerAnswer);
    }

    public function testExistsSubmittingForTheFirstTime()
    {
        // ** Persons
        // Submitted via form
        $submittedPerson = $this->createSubmittedPerson();

        // ** Mocks
        $personRepo = $this->createMock(PersonRepository::class);
        $personRepo
            ->expects($this->exactly(1))
            ->method('findBy') // Need to use `findBy` not `findOneBy` as there could be dup'ed emails or phone numbers
            ->with([
                'email' => 'attending@attend.com',
            ])
            ->willReturn([])
        ;

        $personManager = new PersonManager($personRepo);

        // ** Tests
        $managerAnswer = $personManager->exists($submittedPerson);

        $this->assertSamePersons($submittedPerson, $managerAnswer);
    }

    public function testExistsSubmittingShaddowRegistration()
    {
        // ** Persons
        // Submitted via form
        $submittedPerson = $this->createSubmittedPerson();
        // Returned found in the database
        $repoFoundPerson = $this->createSubmittedPerson();
        $repoFoundPerson
            ->setFirstName('TADA')
            ->setLastName('BOOM')
        ;

        // ** Mocks
        $personRepo = $this->createMock(PersonRepository::class);
        $personRepo
            ->expects($this->exactly(1))
            ->method('findBy') // Need to use `findBy` not `findOneBy` as there could be dup'ed emails or phone numbers
            ->with([
                'email' => 'attending@attend.com',
            ])
            ->willReturn([$repoFoundPerson])
        ;

        $personManager = new PersonManager($personRepo);

        // ** Tests
        $managerAnswer = $personManager->exists($submittedPerson);

        // This will be the same person, because it method exist will see names are not the same and return the initial person
        $this->assertSamePersons($submittedPerson, $managerAnswer);
    }

    private function assertSamePersons(Person $submittedPerson, Person $personManagerAnswer)
    {
        $this->assertSame($submittedPerson, $personManagerAnswer);

        $this->assertEquals($submittedPerson->getFirstName(), $personManagerAnswer->getFirstName());
        $this->assertEquals($submittedPerson->getLastName(), $personManagerAnswer->getLastName());
    }

    private function createSubmittedPerson(): Person
    {
        $submittedPerson = new Person();
        $submittedPerson
            ->setEmail('attending@attend.com')
            ->setPhone('7855559876')
            ->setFirstName('attending')
            ->setLastName('person')
        ;

        return $submittedPerson;
    }
}
