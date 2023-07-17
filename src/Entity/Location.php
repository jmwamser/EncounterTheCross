<?php

namespace App\Entity;

use App\Entity\Traits\AddressTrait;
use App\Entity\Traits\CoreEntityTrait;
use App\Entity\Traits\EntityIdTrait;
use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ReflectionClass;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    use CoreEntityTrait;
    use AddressTrait;

    public const TYPE_LAUNCH_POINT = 'launch';
    public const TYPE_EVENT = 'event';

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'location', targetEntity: Event::class)]
    private Collection $events; // this field is for self::TYPE_EVENT only

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\OneToMany(mappedBy: 'launchPoint', targetEntity: EventParticipant::class)]
    private Collection $eventAttendees;

    #[ORM\ManyToMany(targetEntity: Event::class, mappedBy: 'launchPoints')]
    private Collection $launchPointEvents; // this field is for self::TYPE_LAUNCH_POINT only

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->eventAttendees = new ArrayCollection();
        $this->launchPointEvents = new ArrayCollection();
    }

    public function getShortAddress(): string
    {
        $city = empty($city = $this->getCity() ?? '') ? $city : $city.", ";
        $state = empty($state = $this->getState() ?? '') ? $state : $state." ";
        $zip = $this->getZipcode() ?? '';
        return $city.$state.$zip;
    }

    public function getLongAddress(): string
    {
        $cityStateZip = $this->getShortAddress();



        return $this->getLine1()."\n".$cityStateZip."\n".$this->getCountry();
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
     * @return Collection<int, EventParticipant>
     */
    public function getEventAttendees(): Collection
    {
        return $this->eventAttendees;
    }

    public function addEventAttendee(EventParticipant $eventAttendee): self
    {
        if (!$this->eventAttendees->contains($eventAttendee)) {
            $this->eventAttendees->add($eventAttendee);
            $eventAttendee->setLaunchPoint($this);
        }

        return $this;
    }

    public function removeEventAttendee(EventParticipant $eventAttendee): self
    {
        if ($this->eventAttendees->removeElement($eventAttendee)) {
            // set the owning side to null (unless already changed)
            if ($eventAttendee->getLaunchPoint() === $this) {
                $eventAttendee->setLaunchPoint(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getLaunchPointEvents(): Collection
    {
        return $this->launchPointEvents;
    }

    public function addLaunchPointEvent(Event $launchPointEvent): self
    {
        if (!$this->launchPointEvents->contains($launchPointEvent)) {
            $this->launchPointEvents->add($launchPointEvent);
            $launchPointEvent->addLaunchPoint($this);
        }

        return $this;
    }

    public function removeLaunchPointEvent(Event $launchPointEvent): self
    {
        if ($this->launchPointEvents->removeElement($launchPointEvent)) {
            $launchPointEvent->removeLaunchPoint($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName() ?? "";
    }

}
