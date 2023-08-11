<?php

namespace App\Twig\Runtime;

use Symfony\Component\Uid\Uuid;
use Twig\Extension\RuntimeExtensionInterface;

class UuidFormaterRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function encodeUuid(Uuid $uuid): string
    {
        return \UuidFactory::getBase32RowPointer($uuid);
    }
}
