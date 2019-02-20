<?php

namespace App\Controller;

use App\Form\AddArticle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;


class AddArticleController extends AbstractController
{
    /**
     * @Route("/ajouter" , name="_add")
     * @param Environment $environment
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function addAction(Environment $environment){
        $this->denyAccessUnlessGranted('ROLE_USER');
        return new Response($environment->render('pages/add.html.twig'));
    }

    public function addForm(Request $request){
        //TODO complete project Entity

        $formAddArticle = $this->createForm(AddArticle::class);
        $formAddArticle->handleRequest($request);


        if ($formAddArticle->isSubmitted() && $formAddArticle->isValid()) {
            //TODO Implement submition code
            null;
        }
        return $this->render('form/addArticle.html.twig', array(
            'formAddArticle' => $formAddArticle->createView(),
        ));
    }
}