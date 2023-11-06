<?php

namespace App\Service\Exporter;

interface EntityExportableInterface
{
    public function toArray(): array;
}
