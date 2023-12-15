<?php

namespace App\Settings\Global;

use App\Enum\SystemModeEnum;
use Tzunghaor\SettingsBundle\Attribute\Setting;

class SystemSettings
{
    #[Setting]
    private bool $emailNotifications = false;

    //    #[Setting(
    // //        enum: []
    //    )]
    //    private SystemModeEnum $mode = SystemModeEnum::RUNNING;

    #[Setting]
    private array $debugEmailAddresses = [];

    private bool $debugEmails = false;

    #[Setting]
    private bool $maintenanceMode = false;

    #[Setting]
    private bool $registrationDeadlineInforced = false;

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

    public function getDebugEmailAddresses(): array
    {
        return $this->debugEmailAddresses;
    }

    public function setDebugEmailAddresses(array $debugEmailAddresses): void
    {
        $this->debugEmailAddresses = $debugEmailAddresses;
    }

    public function isDebugEmails(): bool
    {
        return $this->debugEmails;
    }

    public function setDebugEmails(bool $debugEmails): void
    {
        $this->debugEmails = $debugEmails;
    }

    public function isRegistrationDeadlineInforced(): bool
    {
        return $this->registrationDeadlineInforced;
    }

    public function setRegistrationDeadlineInforced(bool $registrationDeadlineInforced): void
    {
        $this->registrationDeadlineInforced = $registrationDeadlineInforced;
    }
}
