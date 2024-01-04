<?php

namespace App\Service;

use App\Entity\Person;
use App\Repository\PersonRepository;

class PersonManager
{
    public function __construct(
        private PersonRepository $personRepository
    ) {
    }

    /**
     * 1. look up by email
     * 2. see if first name and last name are the same, if so return 1st found
     *      else return initial person submitted.
     *
     * Will return the Submitted person if none found matching in database.
     */
    public function exists(Person $person): Person
    {
        $found = $this->personRepository->findBy([
            'email' => $person->getEmail(),
        ]);

        if (empty($found)) {
            // No one found
            return $person;

            //            // TODO: issue here could be duplicates of a contact person place holder.
            //            $found = $this->personRepository->findBy([
            //                'phone' => $person->getPhone(),
            //            ]);
        }

        // Found someone
        // ALWAYS use first found person
        $foundPerson = $found[0];
        if ($foundPerson->getFullName() !== $person->getFullName()) {
            return $person;
        }

        return $foundPerson;
    }
}
