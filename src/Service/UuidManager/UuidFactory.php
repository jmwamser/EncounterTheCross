<?php

namespace App\Service\UuidManager;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;

/**
 * @Author: jwamser
 * @CreateAt: 3/3/23
 * Project: EncounterTheCross
 * File Name: UuidFactory.php
 */
class UuidFactory
{
    public static function newUuid(): UuidV4
    {
        return Uuid::v4();
    }

    public static function getBase32RowPointer(Uuid $rowPointer): string
    {
        return $rowPointer->toBase32();
    }

    /**
     * This is a helper function on the entity.
     * Not 100% sure if we want this to stay on the class, i think we do though instead of a service.
     *
     * @param string $base
     * @return Uuid|null
     */
    public static function getRowPointerFromBase32(string $base): ?Uuid
    {
        try {
            return Uuid::fromBase32($base);
        } catch (\Throwable $e) {
            return null;
        }
    }
}