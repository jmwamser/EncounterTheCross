<?php

namespace App\Service\Exporter;

interface EntityExportableInterface
{
    public function getBasicSerialization(): array;

    public function getExtendedSerialization(): array;
}
