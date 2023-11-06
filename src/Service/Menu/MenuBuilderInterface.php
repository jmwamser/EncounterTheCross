<?php

namespace App\Service\Menu;

use Knp\Menu\ItemInterface;

interface MenuBuilderInterface
{
    public function build(): ItemInterface;

    public function addChild(string $child, array $options = []): self;
}
