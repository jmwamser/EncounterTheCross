<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait AddressTrait
{
    #[ORM\Column(length: 255)]
    protected ?string $line1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    protected ?string $line2 = null;

    #[ORM\Column(length: 255)]
    protected ?string $city = null;

    #[ORM\Column(length: 255)]
    protected ?string $state = null;

    #[ORM\Column(length: 255)]
    protected ?string $zipcode = null;

    #[ORM\Column(length: 255)]
    protected ?string $country = null;

    public function getLine1(): ?string
    {
        return $this->line1;
    }

    public function setLine1(string $line1): self
    {
        $this->line1 = $line1;

        return $this;
    }

    public function getLine2(): ?string
    {
        return $this->line2;
    }

    public function setLine2(?string $line2): self
    {
        $this->line2 = $line2;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }
}
