<?php

namespace App\Controller;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ProjectController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/project", name="_projects")
     * @param Environment $environment
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function projectsAction(Environment $environment){
        $this->denyAccessUnlessGranted('ROLE_USER');
        $projects = $this->initProjectPage();
        return new Response($environment->render('pages/projects.html.twig', array('projects' => $projects)));
    }

    /**
     * @Route("/project/{id}", name="_project")
     * @param Environment $environment
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function projectAction(Environment $environment, $id){
        $this->denyAccessUnlessGranted('ROLE_USER');
        $repository = $this->getDoctrine()->getRepository(Project::class);
        $project = $repository->find($id);
        return new Response($environment->render('pages/project_details.html.twig', array('project' => $project)));
    }

    //init the project page whit the 9 first row of the database
    private function initProjectPage(){
        $query = $this->entityManager->createQuery('SELECT p FROM App\\Entity\\Project p ORDER BY p.project_name ')->setMaxResults(9);
        $result = $query->getResult();
        return $result;
    }

    //TODO create function for query the nexts 9 articles (btn 'next')
}
