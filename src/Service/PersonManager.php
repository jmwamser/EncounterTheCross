<?php

namespace App\Service;

use App\Entity\Person;
use App\Repository\PersonRepository;

class PersonManager
{

    public function __construct(
        private PersonRepository $personRepository
    ){
    }

    /**
     * Will return the Submitted person if none found matching in database.
     */
    public function exists(Person $person): Person
    {
        $found = $this->personRepository->findOneBy([
            'email' => $person->getEmail(),
        ]);

        if (null === $found) {
            //TODO: issue here could be duplicates of a contact person place holder.
            $found = $this->personRepository->findOneBy([
                'phone' => $person->getPhone(),
            ]);
        }

        return $found ?? $person;
    }
}