<?php

namespace App\Entity;

use App\Entity\Traits\AddressTrait;
use App\Entity\Traits\CoreEntityTrait;
use App\Entity\Traits\QuestionsAndConcernsTrait;
use App\Repository\EventParticipantRepository;
use App\Service\Exporter\EntityExportableInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EventParticipantRepository::class)]
class EventParticipant implements EntityExportableInterface
{
    use CoreEntityTrait;
    use AddressTrait;
    use QuestionsAndConcernsTrait;

    public const TYPE_SERVER = 'server';
    public const TYPE_ATTENDEE = 'attendee';

    public const PAYMENT_METHOD_ATDOOR = 'DOOR';
    public const PAYMENT_METHOD_SCHOLARSHIP = 'SCHOLARSHIP';
    public const PAYMENT_METHODS = [
        self::PAYMENT_METHOD_ATDOOR,
        self::PAYMENT_METHOD_SCHOLARSHIP,
    ];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $church = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $invitedBy = null;

    #[ORM\ManyToOne(
        cascade: ['persist'],
        inversedBy: 'eventAttendees'
    )]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(
        message: 'Please choose where you will launch from.'
    )]
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

    #[ORM\Column]
    private ?bool $paid = false;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull(
        message: 'Please select how you will pay.',
    )]
    private ?string $paymentMethod = null;

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

    public function toArray(): array
    {
        return [
            'type'=> $this->getType(),
            'name' => $this->getFullName(),
            'email' => $this->getPerson()->getEmail(),
            'phone' => $this->getPerson()->getPhone(),
            'contactPerson' => $this->getAttendeeContactPerson()?->getDetails()->getFullName(),
            'contactRelation' => $this->getAttendeeContactPerson()?->getRelationship(),
            'contactPhone' => $this->getAttendeeContactPerson()?->getDetails()->getPhone(),
            'invitedBy' => $this->getInvitedBy(),
            'paid' => $this->paid ? 'X' : '',
            'paymentMethod' => $this->paymentMethod ?? '',
        ];
    }

    public function isPaid(): ?bool
    {
        return $this->paid;
    }

    public function setPaid(bool $paid): static
    {
        $this->paid = $paid;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?string $paymentMethod): static
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }
}
