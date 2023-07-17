<?php

namespace App\Service\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class MenuBuilderFactory
{
    public function __construct(private readonly GrayscaleMenuBuilder $menuBuilder)
    {
    }

    public function createMainMenu(): ItemInterface
    {
        $mainMenu = $this->menuBuilder;

        //About Page
        $mainMenu->addChild(
            'About', [
                'uri' => '#about',
            ])
        ;

        // Register Pages
        $mainMenu->addChild(
            'Register', [
                'uri' => '/register'
            ]
        );

        // Testimony Pages
        $mainMenu->addChild(
            'Testimonials', [
                'uri' => '#testimonials'
            ])
        ;

        return $mainMenu->build();
    }
}