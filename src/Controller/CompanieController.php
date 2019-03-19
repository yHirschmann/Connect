<?php

namespace App\Controller;

use App\Entity\CompanieEmployee;
use App\Entity\Companies;
use App\Entity\Employee;
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
        return new Response($environment->render('companie/companies.html.twig', array('companies' => $this->initCompaniePage())));
    }

    /**
     * @Route("/entreprise/{id}", name="_companie")
     * @param Environment $environment
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function companieAction(Environment $environment, $id){
        $this->denyAccessUnlessGranted('ROLE_USER');
        $companie = $this->getDoctrine()->getRepository(Companies::class)->find($id);
        $employees = $this->getDoctrine()->getRepository(CompanieEmployee::class)->findEmployeesInCompany($companie->getId());
        foreach($employees as $employee){
            $companie->addEmployee($employee);
        }
        return new Response($environment->render('companie/companie_details.html.twig', array('companie' => $companie)));
    }

    private function initCompaniePage(){
        return $this->entityManager->getRepository(Companies::class)->findAll();
    }
}
