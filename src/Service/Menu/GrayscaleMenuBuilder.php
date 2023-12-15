<?php

namespace App\Service\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class GrayscaleMenuBuilder implements MenuBuilderInterface
{
    private array $items = [];

    public function __construct(private readonly FactoryInterface $factory)
    {
    }

    public const MAINMENU = 'root';

    public function build(): ItemInterface
    {
        $menu = $this->factory->createItem(self::MAINMENU)
            ->setChildrenAttribute('class', 'navbar-nav ms-auto')
        ;

        foreach ($this->items as $name => $options) {
            $menu->addChild($name, $options)
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link')
            ;
        }

        return $menu;
    }

    public function addChild(string $child, array $options = []): self
    {
        $this->items[$child] = $options;

        return $this;
    }
}
