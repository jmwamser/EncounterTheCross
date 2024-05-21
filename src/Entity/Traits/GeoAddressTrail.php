<?php

namespace App\Entity\Traits;

use Daften\Bundle\AddressingBundle\Entity\AddressEmbeddable;
use Daften\Bundle\AddressingBundle\Validator\Constraints as AddressingBundleAssert;
use Doctrine\ORM\Mapping as ORM;

trait GeoAddressTrail
{
    #[ORM\Embedded(class: AddressEmbeddable::class)]
    #[AddressingBundleAssert\EmbeddedAddressFormatConstraint(fieldOverrides: [
        'addressLine1' => 'required',
        'postalCode' => 'required',
        'locality' => 'required',
        'organization' => 'required',
        'givenName' => 'required',
        'familyName' => 'required',
        'addressLine2' => 'optional',
        'additionalName' => 'hidden',
        'administrativeArea' => 'hidden',
        'dependentLocality' => 'hidden',
        'sortingCode' => 'hidden',
    ])]
    private AddressEmbeddable $address;

    /**
     * AddressExample constructor.
     */
    public function __construct()
    {
        $this->address = new AddressEmbeddable();
    }

    /**
     * @return AddressEmbeddable
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param AddressEmbeddable $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }
}
