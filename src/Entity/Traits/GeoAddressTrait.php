<?php

namespace App\Entity\Traits;

use Daften\Bundle\AddressingBundle\Entity\AddressEmbeddable;
use Daften\Bundle\AddressingBundle\Validator\Constraints as AddressingBundleAssert;
use Doctrine\ORM\Mapping as ORM;

trait GeoAddressTrait
{
    //    #[ORM\Embedded(class: AddressEmbeddable::class)]
    #[AddressingBundleAssert\EmbeddedAddressFormatConstraint(fieldOverrides: [
        'addressLine1' => 'hidden',
        'postalCode' => 'required',
        'locality' => 'required',
        'organization' => 'required',
        'givenName' => 'hidden',
        'familyName' => 'hidden',
        'addressLine2' => 'hidden',
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
