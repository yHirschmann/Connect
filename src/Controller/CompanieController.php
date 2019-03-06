<?php

namespace App\Controller;

use App\Entity\Companies;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class CompanieController extends AbstractController
{
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
        return new Response($environment->render('companie/companies.html.twig'));
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
        $project = $repository->find($id);
        return new Response($environment->render('companie/companie_details.html.twig', array('project' => $project)));
    }
}
