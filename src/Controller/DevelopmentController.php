<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\LeaderRepository;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class DevelopmentController extends AbstractController
{

    #[Route(
        '/dev',
        name: 'app_dev',
        env: 'dev',
    )]
    public function index(EventRepository $repo,KernelInterface $app)
    {
        dd($app->getBuildDir(),$app->getProjectDir());
        dd($repo->findUpcomingEvent()?->getPrice());

        dd($this->container->get('tzunghaor_settings.settings_service.global'));
        dump($repo->findAllLeadersWithNotificationOnAndActive());
        dd('test');
    }
}