<?php

namespace App\Service\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class MenuBuilderFactory
{
    //TODO: get routeProvider
    public function __construct(
        private readonly GrayscaleMenuBuilder $menuBuilder,
//        private UrlGeneratorInterface $router,
    ){
    }

    public function createMainMenu(): ItemInterface
    {
        $mainMenu = $this->menuBuilder;

        //About Page
        $mainMenu->addChild(
            'About', [
                'uri' => '/men/#about',
            ])
        ;

        // Testimony Pages
        $mainMenu->addChild(
            'Testimonials', [
            'uri' => '/men/#testimonials'
        ])
        ;

        // Register Pages
        $mainMenu->addChild(
            'Register', [
                'uri' => '/men/register'
            ]
        );

        // Contact - Launch Point Pages
        $mainMenu->addChild(
            'Contact', [
                'uri' => '/men/contact',
            ]
        );

        return $mainMenu->build();
    }
}