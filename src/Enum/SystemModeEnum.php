<?php

namespace App\Enum;

enum SystemModeEnum: string
{
    case RUNNING = 'running';
    case MAINTENANCE = 'maintenance';
    case UPGRADE = 'upgrading';
}
