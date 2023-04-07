<?php

namespace App\Factory;

use App\Entity\Location;
use App\Repository\LocationRepository;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Location>
 *
 * @method        Location|Proxy create(array|callable $attributes = [])
 * @method static Location|Proxy createOne(array $attributes = [])
 * @method static Location|Proxy find(object|array|mixed $criteria)
 * @method static Location|Proxy findOrCreate(array $attributes)
 * @method static Location|Proxy first(string $sortedField = 'id')
 * @method static Location|Proxy last(string $sortedField = 'id')
 * @method static Location|Proxy random(array $attributes = [])
 * @method static Location|Proxy randomOrCreate(array $attributes = [])
 * @method static LocationRepository|RepositoryProxy repository()
 * @method static Location[]|Proxy[] all()
 * @method static Location[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Location[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Location[]|Proxy[] findBy(array $attributes)
 * @method static Location[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Location[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class LocationFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'city' => self::faker()->city(),
            'country' => self::faker()->country(),
            'createdAt' => self::faker()->dateTime(),
            'line1' => self::faker()->streetAddress(),
            'name' => self::faker()->text(255),
            'rowPointer' => new Uuid(self::faker()->uuid()),
            'state' => self::faker()->state(),
            'type' => self::faker()->randomElement(Location::TYPES()),
            'updatedAt' => self::faker()->dateTime(),
            'zipcode' => self::faker()->postcode(),
        ];
    }

    public function launchPoint(): self
    {
        return $this->addState(['type' => Location::TYPE_LAUNCH_POINT]);
    }

    public function event(): self
    {
        return $this->addState(['type' => Location::TYPE_EVENT]);
    }

    public static function allLaunchPoints($min = 1)
    {
        if ($launchPoints = self::findBy(['type'=> Location::TYPE_LAUNCH_POINT])) {
            return $launchPoints;
        }

        return LocationFactory::new('launchPoint')->many($min);
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Location $location): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Location::class;
    }
}
