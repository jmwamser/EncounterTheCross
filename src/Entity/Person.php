<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
class Person
{
    use EntityIdTrait;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    protected ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    protected ?string $phone = null;

    #[ORM\OneToMany(mappedBy: 'details', targetEntity: ContactPerson::class, orphanRemoval: true)]
    private Collection $contactFor;

    public function __construct()
    {
        $this->contactFor = new ArrayCollection();
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Collection<int, ContactPerson>
     */
    public function getContactFor(): Collection
    {
        return $this->contactFor;
    }

    public function addContactFor(ContactPerson $contactFor): self
    {
        if (!$this->contactFor->contains($contactFor)) {
            $this->contactFor->add($contactFor);
            $contactFor->setDetails($this);
        }

        return $this;
    }

    public function removeContactFor(ContactPerson $contactFor): self
    {
        if ($this->contactFor->removeElement($contactFor)) {
            // set the owning side to null (unless already changed)
            if ($contactFor->getDetails() === $this) {
                $contactFor->setDetails(null);
            }
        }

        return $this;
    }

}
