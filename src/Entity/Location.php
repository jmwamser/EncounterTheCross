<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use \ReflectionClass;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    use EntityIdTrait;
    use AddressTrait;

    public const TYPE_LAUNCH_POINT = 'launch';
    public const TYPE_EVENT = 'event';

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'location', targetEntity: Event::class)]
    private Collection $events;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\OneToMany(mappedBy: 'launchPoint', targetEntity: EventAttendee::class)]
    private Collection $eventAttendees;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->eventAttendees = new ArrayCollection();
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

    public static function TYPES(): array
    {
        $oClass = new ReflectionClass(static::class);
        return $oClass->getConstants();
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setLocation($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getLocation() === $this) {
                $event->setLocation(null);
            }
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        if(!in_array($type,self::TYPES())) {
            throw new \InvalidArgumentException('Invalid Type provided for Location');
        }

        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, EventAttendee>
     */
    public function getEventAttendees(): Collection
    {
        return $this->eventAttendees;
    }

    public function addEventAttendee(EventAttendee $eventAttendee): self
    {
        if (!$this->eventAttendees->contains($eventAttendee)) {
            $this->eventAttendees->add($eventAttendee);
            $eventAttendee->setLaunchPoint($this);
        }

        return $this;
    }

    public function removeEventAttendee(EventAttendee $eventAttendee): self
    {
        if ($this->eventAttendees->removeElement($eventAttendee)) {
            // set the owning side to null (unless already changed)
            if ($eventAttendee->getLaunchPoint() === $this) {
                $eventAttendee->setLaunchPoint(null);
            }
        }

        return $this;
    }
}
