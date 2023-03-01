<?php

namespace App\Factory;

use App\Entity\EventParticipant;
use App\Repository\EventParticipantRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<EventParticipant>
 *
 * @method        EventParticipant|Proxy create(array|callable $attributes = [])
 * @method static EventParticipant|Proxy createOne(array $attributes = [])
 * @method static EventParticipant|Proxy find(object|array|mixed $criteria)
 * @method static EventParticipant|Proxy findOrCreate(array $attributes)
 * @method static EventParticipant|Proxy first(string $sortedField = 'id')
 * @method static EventParticipant|Proxy last(string $sortedField = 'id')
 * @method static EventParticipant|Proxy random(array $attributes = [])
 * @method static EventParticipant|Proxy randomOrCreate(array $attributes = [])
 * @method static EventParticipantRepository|RepositoryProxy repository()
 * @method static EventParticipant[]|Proxy[] all()
 * @method static EventParticipant[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static EventParticipant[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static EventParticipant[]|Proxy[] findBy(array $attributes)
 * @method static EventParticipant[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static EventParticipant[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class EventParticipantFactory extends ModelFactory
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
            'launchPoint' => LocationFactory::new(),
            'line1' => self::faker()->text(255),
            'person' => PersonFactory::new(),
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
            // ->afterInstantiate(function(EventParticipant $eventParticipant): void {})
        ;
    }

    protected static function getClass(): string
    {
        return EventParticipant::class;
    }
}
