<?php

namespace App\Entity;

use App\Entity\Traits\AddressTrait;
use App\Entity\Traits\CoreEntityTrait;
use App\Entity\Traits\QuestionsAndConcernsTrait;
use App\Repository\EventParticipantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventParticipantRepository::class)]
class EventParticipant
{
    use CoreEntityTrait;
    use AddressTrait;
    use QuestionsAndConcernsTrait;

    public const TYPE_SERVER = 'server';
    public const TYPE_ATTENDEE = 'attendee';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $church = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $invitedBy = null;

    #[ORM\ManyToOne(
        cascade: ['persist'],
        inversedBy: 'eventAttendees'
    )]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $launchPoint = null;

    #[ORM\ManyToOne(
        cascade: ['persist'],
        inversedBy: 'attendedEvents'
    )]
    #[ORM\JoinColumn(nullable: false)]
    private ?Person $person = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\ManyToOne(
        cascade: ['persist'],
        inversedBy: 'eventParticipants'
    )]
    private ?ContactPerson $attendeeContactPerson = null;

    #[ORM\Column(nullable: true)]
    private ?int $serverAttendedTimes = null;

    #[ORM\ManyToOne(inversedBy: 'eventParticipants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Event $event = null;

    public static function TYPES(): array
    {
        $oClass = new \ReflectionClass(static::class);
        return $oClass->getConstants();
    }

    public function getChurch(): ?string
    {
        return $this->church;
    }

    public function setChurch(string $church): self
    {
        $this->church = $church;

        return $this;
    }

    public function getInvitedBy(): ?string
    {
        return $this->invitedBy;
    }

    public function setInvitedBy(?string $invitedBy): self
    {
        $this->invitedBy = $invitedBy;

        return $this;
    }

    public function getLaunchPoint(): ?Location
    {
        return $this->launchPoint;
    }

    public function setLaunchPoint(?Location $launchPoint): self
    {
        $this->launchPoint = $launchPoint;

        return $this;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): self
    {
        $this->person = $person;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAttendeeContactPerson(): ?ContactPerson
    {
        return $this->attendeeContactPerson;
    }

    public function setAttendeeContactPerson(?ContactPerson $attendeeContactPerson): self
    {
        $this->attendeeContactPerson = $attendeeContactPerson;

        return $this;
    }

    public function getServerAttendedTimes(): ?int
    {
        return $this->serverAttendedTimes;
    }

    public function setServerAttendedTimes(?int $serverAttendedTimes): self
    {
        $this->serverAttendedTimes = $serverAttendedTimes;

        return $this;
    }

    public function getFullName(): string
    {
        $person = $this->getPerson();
        return $person->getFirstName(). " " .$person->getLastName();
    }

    public function __toString(): string
    {
        return $this->getFullName();
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

}
