<?php

namespace App\Entity;

use App\Entity\Traits\CoreEntityTrait;
use App\Repository\LeaderRepository;
use App\Service\RoleManager\Role;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: LeaderRepository::class)]
class Leader implements UserInterface, PasswordAuthenticatedUserInterface
{
    use CoreEntityTrait;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    private ?string $plainPassword;

    #[ORM\OneToOne(targetEntity:Person::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'person_id', referencedColumnName: 'id',nullable: false)]
    private ?Person $person = null;

    #[ORM\ManyToOne(inversedBy: 'launchPointContacts')]
    private ?Location $launchPoint = null;

    /**
     * !! KEY OVERLAP ISSUES - SET TO TRUE IF IT COULD HAPPEN !!
     * @param bool $forceMerge This sets the key to the role that is default,
     *      This will make sure when providing Instance
     *      Roles we don't overwrite anything while including this role as well.
     * @return array
     */
    public static function DEFAULT_ROLES(bool $forceMerge = false): array
    {
        if ($forceMerge) {
            return [Role::DEFAULT => Role::DEFAULT];
        }
        return [Role::DEFAULT];
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        $this->getPerson()?->setEmail($email);

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        // guarantee every user at least has ROLE_USER
        $roles = array_merge(
            $this->roles,
            self::DEFAULT_ROLES(true)
        );

        return array_unique(array_values($roles));
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
         $this->plainPassword = null;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string|null $plainPassword
     */
    public function setPlainPassword(?string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    public function getFullName(): string
    {
        return $this->getPerson()->getFullName();
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(Person $person): self
    {
        $this->person = $person;

        return $this;
    }

    public function getLaunchPoint(): ?Location
    {
        return $this->launchPoint;
    }

    public function setLaunchPoint(?Location $launchPoint): static
    {
        $this->launchPoint = $launchPoint;

        return $this;
    }

    public function __toString(): string
    {
        $person = $this->getPerson();
        return $person->getFirstName().' '.$person->getLastName();
    }
}
