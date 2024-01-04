<?php

/**
 * @Author: jwamser
 *
 * @CreateAt: 4/8/23
 * Project: EncounterTheCross
 * File Name: RoleFormatter.php
 */

namespace App\Service\RoleManager;

use Exception;

class RoleFormatter
{
    public static function formatRolesForForm(array $roles): array
    {
        $keyValueRoles = self::formatRoleKeysToMatchValues($roles);
        $valueRolesMap = array_map(function ($role) {
            return self::formatUserReadableString($role);
        }, $keyValueRoles);

        return array_flip($valueRolesMap);
    }

    public static function formatRoleKeysToMatchValues(array $roles): array
    {
        return array_combine($roles, $roles);
    }

    private static function formatUserReadableArray(array $values)
    {
        return self::formatUserReadable($values) ?? $values;
    }

    private static function formatUserReadableString(string $value)
    {
        return trim(self::formatUserReadable($value, true) ?? $value);
    }

    private static function formatUserReadable(string|array $value, bool $rtnString = false): array|string|null
    {
        try {
            if (!$rtnString && !\is_array($value)) {
                $value = [$value];
            }

            return preg_replace(
                ['/(_)/', '/(ROLE)/'],
                [' '],
                $value
            );
        } catch (Exception $exception) {
            // TODO Log Formatter issue
            // TODO Make RoleFormatterException::class
            throw $exception;

            return null;
        }
    }
}
