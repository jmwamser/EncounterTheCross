<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\LeaderRepository;
use App\Repository\LocationRepository;
use App\Repository\TestimonialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(
        EventRepository $eventRepository,
    ): Response
    {
        $nextEvent = $eventRepository->findUpcomingEvent();

        return $this->render('frontend/index.html.twig', [
            'event' => $nextEvent,
        ]);
    }

    #[Route('/contact', name: 'app_launchpoints')]
    public function contactLaunchPoints(LocationRepository $launchPointRespository)
    {
        //TODO: convert into Twig Component
        $launchPoints = $launchPointRespository->getAllActiveLaunchPoints();

        return $this->render('frontend/launchpoints.html.twig', [
            'launch_points' => $launchPoints,
        ]);
    }

    #[Route('/testimonies', name: 'app_testimonies')]
    public function testimonies()
    {
//        $queryBuilder = $testimonialRepository->findAllTestimoniesQueryBuilder();
//        $adaptor = new QueryAdapter($queryBuilder);
//        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage(
//            $adaptor,
//            $request->query->get('page', 1),
//            9
//        );


        return $this->render('frontend/testimonies.html.twig',[
//            'pager' => $pagerfanta,
        ]);
    }
}
