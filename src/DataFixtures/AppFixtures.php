<?php

namespace App\DataFixtures;

use App\Entity\EventParticipant;
use App\Factory\EventFactory;
use App\Factory\EventParticipantFactory;
use App\Factory\LeaderFactory;
use App\Factory\LocationFactory;
use App\Factory\TestimonialFactory;
use App\Service\RoleManager\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //Create Admin `Leader` so you can login
        LeaderFactory::createOne(['email'=>'dev@dev.com','roles'=>[Role::FULL]]);
        LeaderFactory::createOne(['roles'=>[Role::LEADER_EVENT,Role::LIMITED_FULL]]);
        LeaderFactory::createOne(['roles'=>[Role::LEADER_EVENT,Role::LIMITED_FULL]]);
        LeaderFactory::createOne(['roles'=>[Role::LEADER_EVENT,Role::LIMITED_FULL]]);
        LeaderFactory::createMany(15);

        // Create all Launch Points to use
        LocationFactory::new('launchPoint')->many(8)->create();

        // Make the Events
        EventFactory::createMany(2);

        // Create people that will go to the events
        //Servers
        EventParticipantFactory::new('server')->many(10)->create();
        //Attendees
        EventParticipantFactory::new('attendee')->many(10)->create();

        // Create the Testimonials
        TestimonialFactory::createMany(50);

        $manager->flush();
    }
}
