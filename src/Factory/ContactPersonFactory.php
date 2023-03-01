<?php

namespace App\Factory;

use App\Entity\ContactPerson;
use App\Repository\ContactPersonRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<ContactPerson>
 *
 * @method        ContactPerson|Proxy create(array|callable $attributes = [])
 * @method static ContactPerson|Proxy createOne(array $attributes = [])
 * @method static ContactPerson|Proxy find(object|array|mixed $criteria)
 * @method static ContactPerson|Proxy findOrCreate(array $attributes)
 * @method static ContactPerson|Proxy first(string $sortedField = 'id')
 * @method static ContactPerson|Proxy last(string $sortedField = 'id')
 * @method static ContactPerson|Proxy random(array $attributes = [])
 * @method static ContactPerson|Proxy randomOrCreate(array $attributes = [])
 * @method static ContactPersonRepository|RepositoryProxy repository()
 * @method static ContactPerson[]|Proxy[] all()
 * @method static ContactPerson[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static ContactPerson[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static ContactPerson[]|Proxy[] findBy(array $attributes)
 * @method static ContactPerson[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static ContactPerson[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class ContactPersonFactory extends ModelFactory
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
            'createdAt' => self::faker()->dateTime(),
            'details' => PersonFactory::new(),
            'relationship' => self::faker()->text(255),
            'rowPointer' => null, // TODO add UUID type manually
            'updatedAt' => self::faker()->dateTime(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(ContactPerson $contactPerson): void {})
        ;
    }

    protected static function getClass(): string
    {
        return ContactPerson::class;
    }
}
