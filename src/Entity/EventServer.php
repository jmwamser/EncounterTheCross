<?php

namespace App\Entity;

use App\Repository\EventServerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventServerRepository::class)]
class EventServer
{
    use EntityIdTrait;
    use QuestionsAndConcernsTrait;
}
