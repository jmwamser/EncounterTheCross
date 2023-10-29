<?php

namespace App\Controller;

use App\Settings\Global\SystemSettings;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as CoreAbstractController;
use Tzunghaor\SettingsBundle\Service\SettingsService;

class AbstractController extends CoreAbstractController
{
    public static function getSubscribedServices(): array
    {
        return array_merge(
            parent::getSubscribedServices(),
            [
                'tzunghaor_settings.settings_service.global' => '?'.SettingsService::class,
            ]
        );
    }

    protected function getGlobalSettings(): SystemSettings
    {
        if (!$this->container->has('tzunghaor_settings.settings_service.global')) {
            throw new \LogicException('The SettingsBundle is not registered in your application. Try running "composer require tzunghaor/settings-bundle".');
        }

        return $this->container->get('tzunghaor_settings.settings_service.global')->getSection(SystemSettings::class);
    }
}