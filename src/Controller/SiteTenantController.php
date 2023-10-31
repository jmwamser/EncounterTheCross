<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteTenantController extends AbstractController
{
    #[Route(
        '/',
        host: '{subdomain}.encounterthecross.com',
        name: 'app_site_redirect',
        requirements: ['subdomain' => 'men|women'],
    )]
    public function redirectToSite(string $subdomain): Response
    {
        if ($subdomain === 'women') {
            return $this->womenSubDirectory();
        }

        return $this->redirect("https://www.encounterthecross.com/{$subdomain}");
    }

    #[Route(
        '/',
        host: 'www.encounterthecross.com',
    )]
    public function chooseYourSite(): Response
    {
        return $this->render('frontend/split.index.html.twig');
    }

    #[Route(
        '/{site}',
        requirements: ['site'=>'women'],
        host: 'www.encounterthecross.com',
    )]
    public function womenSubDirectory()
    {
        return $this->redirect("https://women.encounterthecross.com");
    }
}