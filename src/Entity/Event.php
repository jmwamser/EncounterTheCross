<?php

namespace App\Entity;

use App\Entity\Traits\CoreEntityTrait;
use App\Entity\Traits\EntityIdTrait;
use App\Exception\InvalidLocationType;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ReadableCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    use CoreEntityTrait;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $start = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $end = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $registrationDeadLineServers = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $location = null;

    #[ORM\ManyToMany(targetEntity: Location::class, inversedBy: 'launchPointEvents')]
    private Collection $launchPoints;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: EventParticipant::class)]
    private Collection $eventParticipants;

    #[ORM\Column(type: 'decimal',precision: 20,scale: 8)]
    private ?string $price = null;

    public function __construct()
    {
        $this->launchPoints = new ArrayCollection();
        $this->eventParticipants = new ArrayCollection();
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getRegistrationDeadLineServers(): ?\DateTimeInterface
    {
        return $this->registrationDeadLineServers;
    }

    public function setRegistrationDeadLineServers(\DateTimeInterface $registrationDeadLineServers): self
    {
        $this->registrationDeadLineServers = $registrationDeadLineServers;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        if (Location::TYPE_EVENT !== $location->getType()) {
            throw new InvalidLocationType('Location',Location::TYPE_EVENT);
        }

        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection<int, Location>
     */
    public function getLaunchPoints(): Collection
    {
        return $this->launchPoints;
    }

    public function addLaunchPoint(Location $launchPoint): self
    {
        if (!$this->launchPoints->contains($launchPoint)) {
            $this->launchPoints->add($launchPoint);
        }

        return $this;
    }

    public function removeLaunchPoint(Location $launchPoint): self
    {
        $this->launchPoints->removeElement($launchPoint);

        return $this;
    }

    public function getTotalServers(): int
    {
        $total = 0;
        foreach($this->getEventParticipants()->getIterator() as $server) {
            if ($server->getType() === EventParticipant::TYPE_SERVER) {
                $total++;
            }
        }

        return $total;
    }

    public function getTotalAttendees(): int
    {
        $total = 0;

        /** @var EventParticipant $attendee */
        foreach($this->getEventParticipants()->getIterator() as $attendee) {
            if ($attendee->getType() === EventParticipant::TYPE_ATTENDEE) {
                $total++;
            }
        }

        return $total;
    }


    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return Collection<int, EventParticipant>
     */
    public function getEventParticipants(): Collection
    {
        return $this->eventParticipants;
    }

    public function addEventParticipant(EventParticipant $eventParticipant): self
    {
        if (!$this->eventParticipants->contains($eventParticipant)) {
            $this->eventParticipants->add($eventParticipant);
            $eventParticipant->setEvent($this);
        }

        return $this;
    }

    public function removeEventParticipant(EventParticipant $eventParticipant): self
    {
        if ($this->eventParticipants->removeElement($eventParticipant)) {
            // set the owning side to null (unless already changed)
            if ($eventParticipant->getEvent() === $this) {
                $eventParticipant->setEvent(null);
            }
        }

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }
}
