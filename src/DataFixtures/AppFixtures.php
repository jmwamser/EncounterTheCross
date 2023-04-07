<?php

namespace App\DataFixtures;

use App\Entity\EventParticipant;
use App\Factory\EventFactory;
use App\Factory\EventParticipantFactory;
use App\Factory\LocationFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //TODO: Create Admin `Leader` so you can login

        // Create all Launch Points to use
        LocationFactory::new('launchPoint')->many(8)->create();

        // Make the Events
        EventFactory::createMany(2);

        // Create people that will go to the events
        //Servers
        EventParticipantFactory::new('server')->many(10)->create();
        //Attendees
        EventParticipantFactory::new('attendee')->many(10)->create();


        $manager->flush();
    }
}
