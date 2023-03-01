<?php

namespace App\Entity;

use App\Entity\Traits\CoreEntityTrait;
use App\Entity\Traits\EntityIdTrait;
use App\Exception\InvalidLocationType;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToMany(targetEntity: Location::class)]
    private Collection $launchPoint;

    public function __construct()
    {
        $this->launchPoint = new ArrayCollection();
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
    public function getLaunchPoint(): Collection
    {
        return $this->launchPoint;
    }

    public function addLaunchPoint(Location $launchPoint): self
    {
        if (Location::TYPE_LAUNCH_POINT !== $launchPoint->getType()) {
            throw new InvalidLocationType('Launch Point',Location::TYPE_LAUNCH_POINT);
        }

        if (!$this->launchPoint->contains($launchPoint)) {
            $this->launchPoint->add($launchPoint);
        }

        return $this;
    }

    public function removeLaunchPoint(Location $launchPoint): self
    {
        $this->launchPoint->removeElement($launchPoint);

        return $this;
    }
}
