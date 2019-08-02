<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profiles", name="_profileList")
     * @param Environment $environment
     * @return Response
     */
    public function profileListAction(Environment $environment)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $formResponse = $this->forward('App\\Controller\\SearchController::searchBar');
        if($formResponse->isRedirection()) {
            return $formResponse;
        }

        return $this->render('profile/profiles.html.twig', [
            'form' => $formResponse,
        ]);
    }
}
