<?php

namespace App\Entity;

use App\Repository\ContactPersonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactPersonRepository::class)]
class ContactPerson
{
    use EntityIdTrait;

    #[ORM\Column(length: 255)]
    private ?string $relationship = null;

    #[ORM\ManyToOne(inversedBy: 'contactFor')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Person $details = null;

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
}
