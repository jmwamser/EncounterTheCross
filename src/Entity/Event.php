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

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $location = null;

    #[ORM\ManyToMany(targetEntity: Location::class, inversedBy: 'launchPointEvents')]
    private Collection $launchPoints;

    public function __construct()
    {
        $this->launchPoints = new ArrayCollection();
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
        foreach($this->getLaunchPoints()->getIterator() as $launchPoint) {
            $servers = $this->getEventServers($launchPoint);

            $total += $servers->count();
        }

        return $total;
    }

    public function getTotalAttendees(): int
    {
        $total = 0;
        foreach($this->getLaunchPoints()->getIterator() as $launchPoint) {
            $servers = $this->getEventServers($launchPoint);

            $total += $servers->count();
        }

        return $total;
    }

    private function getEventServers(Location $launchPoint): ReadableCollection
    {
        return $this->filterLaunchPointEventAttendees($launchPoint,EventParticipant::TYPE_SERVER);
    }

    private function getEventAttendees(Location $launchPoint): ReadableCollection
    {
        return $this->filterLaunchPointEventAttendees($launchPoint,EventParticipant::TYPE_ATTENDEE);
    }

    private function filterLaunchPointEventAttendees(Location $launchPoint, string $type): ReadableCollection
    {
        if (Location::TYPE_EVENT === $launchPoint->getType()) {
            throw new InvalidLocationType($this->name,Location::TYPE_LAUNCH_POINT);
        }

        return $launchPoint->getEventAttendees()->filter(function(EventParticipant $attendee) use ($type) {
            return $attendee->getType() === $type;
        });
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
