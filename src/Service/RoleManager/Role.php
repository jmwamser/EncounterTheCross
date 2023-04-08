<?php
/**
 * @Author: jwamser
 * @CreateAt: 4/8/23
 * Project: EncounterTheCross
 * File Name: Role.php
 */

namespace App\Service\RoleManager;

/**
 * This class is used to create constance of role definitions
 */
class Role
{
    // Constant ROLE Names
    const SUPER_ADMIN = "ROLE_SUPER_ADMIN";

    const ADMIN = "ROLE_ADMIN"; // Just a normal Admin

    const USER = "ROLE_USER"; // Normal User

    /*
     * Constant ROLE Levels
     *
     * FULL: the user role that can do everything
     * LIMITED_FULL: the user role that can do ALMOST all admin things
     */
    const FULL = self::SUPER_ADMIN;
    const LIMITED_FULL = self::ADMIN;
    const DEFAULT = self::USER;
}