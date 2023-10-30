<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\LeaderRepository;
use Symfony\Component\Routing\Annotation\Route;

class DevelopmentController extends AbstractController
{

    #[Route(
        '/dev',
        name: 'app_dev',
        env: 'dev',
    )]
    public function index(EventRepository $repo)
    {
        dd($repo->findUpcomingEvent()?->getPrice());

        dd($this->container->get('tzunghaor_settings.settings_service.global'));
        dump($repo->findAllLeadersWithNotificationOnAndActive());
        dd('test');
    }
}