<?php

namespace App\Entity;

use App\Entity\Traits\CoreEntityTrait;
use App\Entity\Traits\EntityIdTrait;
use App\Repository\ContactPersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactPersonRepository::class)]
class ContactPerson
{
    use CoreEntityTrait;

    #[ORM\Column(length: 255)]
    private ?string $relationship = null;

    #[ORM\ManyToOne(
        cascade: ['persist'],
        inversedBy: 'contactFor'
    )]
    #[ORM\JoinColumn(nullable: false)]
    private ?Person $details = null;

    #[ORM\OneToMany(
        mappedBy: 'attendeeContactPerson',
        targetEntity: EventParticipant::class,
        cascade: ['persist'],
        orphanRemoval: true
    )]
    private Collection $eventParticipants;

    public function __construct()
    {
        $this->eventParticipants = new ArrayCollection();
    }

    public function getRelationship(): ?string
    {
        return $this->relationship;
    }

    public function setRelationship(string $relationship): self
    {
        $this->relationship = $relationship;

        return $this;
    }

    public function getDetails(): ?Person
    {
        return $this->details;
    }

    public function setDetails(?Person $details): self
    {
        $this->details = $details;

        return $this;
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
            $eventParticipant->setAttendeeContactPerson($this);
        }

        return $this;
    }

    public function removeEventParticipant(EventParticipant $eventParticipant): self
    {
        if ($this->eventParticipants->removeElement($eventParticipant)) {
            // set the owning side to null (unless already changed)
            if ($eventParticipant->getAttendeeContactPerson() === $this) {
                $eventParticipant->setAttendeeContactPerson(null);
            }
        }

        return $this;
    }

    public function getFullName(): string
    {
        return $this->getDetails()->getFullName();
    }
    public function __toString(): string
    {
        return $this?->details->__ToString() ?? '';
    }


}
