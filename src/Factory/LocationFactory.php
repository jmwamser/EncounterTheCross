<?php

namespace App\Factory;

use App\Entity\Location;
use App\Repository\LocationRepository;
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
            'city' => self::faker()->text(255),
            'country' => self::faker()->text(255),
            'createdAt' => self::faker()->dateTime(),
            'line1' => self::faker()->text(255),
            'name' => self::faker()->text(255),
            'rowPointer' => null, // TODO add UUID type manually
            'state' => self::faker()->text(255),
            'type' => self::faker()->text(255),
            'updatedAt' => self::faker()->dateTime(),
            'zipcode' => self::faker()->text(255),
        ];
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
