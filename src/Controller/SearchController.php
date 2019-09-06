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

/**
 * Class SearchController
 * @package App\Controller
 */
class SearchController extends AbstractController
{
    /**
     * @Route("/rechercher", name="_search")
     * @param Request $request
     * @param Environment $environment
     * @return Response
     */
    public function searchAction(Request $request, Environment $environment){
        $this->denyAccessUnlessGranted('ROLE_USER');
        $formResponse = $this->forward('App\\Controller\\SearchController::searchBar');

        $data = $request->query->get('data')['search'];

        $doctrine = $this->getDoctrine();
        $companieRepository = $doctrine->getRepository(Companies::class);
        $contactRepository = $doctrine->getRepository(Employee::class);
        $projectRepository = $doctrine->getRepository(Project::class);

        $companies = $companieRepository->findByQuery($data);
        $contacts = $contactRepository->findByQuery($data);
        $projects = $projectRepository->findByQuery($data);

        return $this->render('search/search.html.twig',[
            'form' => $formResponse,
            'companies' => $companies,
            'contacts' => $contacts,
            'projects' => $projects,
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
