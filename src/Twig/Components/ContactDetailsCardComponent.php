<?php

namespace App\Twig\Components;

use App\Entity\Leader;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('contact_details_card')]
final class ContactDetailsCardComponent
{
    public Leader $leader;
}
