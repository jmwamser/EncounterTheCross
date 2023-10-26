<?php

namespace App\Controller;

use App\Repository\LeaderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DevelopmentController extends AbstractController
{

    #[Route(
        '/dev',
        name: 'app_dev',
        env: 'dev',
    )]
    public function index(LeaderRepository $repo)
    {
        dump($repo->findAllLeadersWithNotificationOnAndActive());
        dd('test');
    }
}