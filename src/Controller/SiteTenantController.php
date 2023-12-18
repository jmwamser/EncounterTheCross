<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteTenantController extends AbstractController
{
    #[Route(
        '/',
        host: '{subdomain}{domain}',
        name: 'app_site_redirect',
        requirements: [
            'subdomain' => 'men|women|www|',
            'domain' => '%public_domain_core%',
        ],
    )]
    public function redirectToSite(string $subdomain): Response
    {
        if ('women' === $subdomain) {
            return $this->womenSubDirectory();
        }

        if ('www' === $subdomain || empty($subdomain)) {
            return $this->render('frontend/split.index.html.twig');
        }

        return $this->redirect("/{$subdomain}");
    }

    #[Route(
        '/{site}',
        requirements: ['site' => 'women'],
        host: '%public_domains_allowed%',
    )]
    public function womenSubDirectory()
    {
        return $this->redirect('https://women.encounterthecross.com');
    }
}
