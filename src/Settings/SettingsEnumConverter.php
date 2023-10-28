<?php

namespace App\Settings;

use App\Enum\SystemModeEnum;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;
use Symfony\Component\PropertyInfo\Type;
use Tzunghaor\SettingsBundle\Service\SettingConverterInterface;
use UnitEnum;

class SettingsEnumConverter implements SettingConverterInterface
{
    public function supports(Type $type): bool
    {
        dump($type);
//        return true;
        return is_a($type->getClassName(),SystemModeEnum::class,true);
    }

    /**
     * @param Type $type
     * @param UnitEnum $value
     * @return string
     */
    public function convertToString(Type $type, $value): string
    {
        return '';
        return $value->value;
    }

    public function convertFromString(Type $type, string $value)
    {
        return SystemModeEnum::tryFrom($value);
    }
}
