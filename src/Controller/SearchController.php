<?php

namespace App\Controller;

use App\Form\SearchBar;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class SearchController extends AbstractController
{
    /**
     * @Route("/s", name="_search")
     * @param Environment $environment
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function searchAction(Environment $environment){
        $this->denyAccessUnlessGranted('ROLE_USER');

        return new Response($environment->render('search/search.html.twig'));
    }

    public function searchBar(Request $request){

            $options = array('csrf_protection' => false);
            $formSearch = $this->createForm(SearchBar::class, null, $options);
            $formSearch->handleRequest($request);

            if($formSearch->isSubmitted() && $formSearch->isValid())
            {

                return $this->redirectToRoute('_search', ['test' => $request->request]);
            }

            return $this->render('search/searchBar.html.twig', array(
                'formSearch' => $formSearch->createView(),
            ));
    }
}
