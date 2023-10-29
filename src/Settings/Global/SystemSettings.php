<?php

namespace App\Settings\Global;

use App\Enum\SystemModeEnum;
use Tzunghaor\SettingsBundle\Attribute\Setting;

class SystemSettings
{
    #[Setting]
    private bool $emailNotifications = false;

//    #[Setting(
////        enum: []
//    )]
//    private SystemModeEnum $mode = SystemModeEnum::RUNNING;

    #[Setting]
    private bool $maintenanceMode = false;

    public function isEmailNotificationsTurnedOn(): bool
    {
        return $this->isEmailNotifications();
    }

    public function isEmailNotifications(): bool
    {
        return $this->emailNotifications;
    }

    public function setEmailNotifications(bool $emailNotifications): void
    {
        $this->emailNotifications = $emailNotifications;
    }

//    public function getMode(): SystemModeEnum
//    {
//        return $this->mode;
//    }
//
//    public function setMode(SystemModeEnum $mode): void
//    {
//        $this->mode = $mode;
//    }

    public function isMaintenanceMode(): bool
    {
        return $this->maintenanceMode;
    }

    public function setMaintenanceMode(bool $maintenanceMode): void
    {
        $this->maintenanceMode = $maintenanceMode;
    }

}