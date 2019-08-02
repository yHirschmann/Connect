<?php

namespace App\Controller;

use App\Entity\Companies;
use App\Entity\Employee;
use App\Entity\Project;
use App\Form\SearchBar;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class SearchController extends AbstractController
{
    /**
     * @Route("/rechercher", name="_search")
     * @param Request $request
     * @param Environment $environment
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function searchAction(Request $request, Environment $environment){
        $this->denyAccessUnlessGranted('ROLE_USER');
        $formResponse = $this->forward('App\\Controller\\SearchController::searchBar');

        $data = $request->query->get('data')['search'];

        $doctrine = $this->getDoctrine();
        $companieRepository = $doctrine->getRepository(Companies::class);
        $contactRepository = $doctrine->getRepository(Employee::class);
        $projectRepository = $doctrine->getRepository(Project::class);

        $companies = $companieRepository->findBySearch($data);
        $contacts = $contactRepository->findByQuery($data);
        dump($companies);
        dump($contacts);

        return $this->render('search/search.html.twig',[
            'form' => $formResponse
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function searchBar(Request $request){
        /* @var $requestStack RequestStack */
        $requestStack = $this->get('request_stack');
        $masterRequest = $requestStack->getCurrentRequest();
        assert(!is_null($masterRequest));

        $formSearch = $this->createForm(SearchBar::class);
        $formSearch->handleRequest($masterRequest);

        if($formSearch->isSubmitted() && $formSearch->isValid())
        {
            $data = $formSearch->getData();
            return $this->redirectToRoute('_search', ['data' => $data]);
        }

        return $this->render('search/searchBar.html.twig', array(
            'formSearch' => $formSearch->createView(),
        ));
    }

}
