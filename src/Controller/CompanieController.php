<?php

namespace App\Controller;

use App\Entity\Companies;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class CompanieController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/entreprise", name="_companies")
     * @param Environment $environment
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function companiesAction(Environment $environment){
        $this->denyAccessUnlessGranted('ROLE_USER');
        $companies = $this->initCompaniePage();
        return new Response($environment->render('companie/companies.html.twig', array('companies' => $companies)));
    }

    /**
     * @Route("/entreprise/{id}", name="_companie")
     * @param Environment $environment
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function projectAction(Environment $environment, $id){
        $this->denyAccessUnlessGranted('ROLE_USER');
        $repository = $this->getDoctrine()->getRepository(Companies::class);
        $companie = $repository->find($id);
        return new Response($environment->render('companie/companie_details.html.twig', array('companie' => $companie)));
    }

    private function initCompaniePage(){
        $query = $this->entityManager->createQuery('SELECT c FROM App\\Entity\\Companies c ORDER BY c.companie_name ')->setMaxResults(12);
        $result = $query->getResult();
        return $result;
    }
}
