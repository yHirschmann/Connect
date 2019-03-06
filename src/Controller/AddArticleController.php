<?php

namespace App\Controller;

use App\Entity\Companies;
use App\Form\AddCompanieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
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
    public function index()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('add_article/AddArticle.html.twig', [
            'controller_name' => 'AddArticleController',
        ]);
    }

    /**
     * @Route("/ajouter/entreprise" , name="_addCompanie")
     * @param ValidatorInterface $validator
     * @param Request $request
     * @return Response
     */
    public function addCompanie(ValidatorInterface $validator,Request $request){
        $this->denyAccessUnlessGranted('ROLE_USER');
        $entityManager = $this->getDoctrine()->getManager();
        $companie = new Companies();

        $form = $this->createForm(AddCompanieType::class,$companie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $companie = $form->getData();
            $companie = $companie->formatCompaniePhoneNumber($companie);
            $companie = $companie->formatCompanieSocialReason($companie);

            if(empty($this  ->getDoctrine()
                            ->getRepository(Companies::class)
                            ->findByExisting($companie->getCompanieName(),$companie->getCity(),$companie->getAdress())))
            {
                $entityManager->persist($companie);
                $entityManager->flush();
            }else{
                dump('erreur');
                //TODO Display error saying "The companie that you are trying to add already exist"
                $this->addFlash('existing','Cette entreprise existe déjà dans la base de donnée.');
                return $this->redirectToRoute("_addCompanie");
            }

        }

        return $this->render('form/AddCompanie.html.twig', array(
            'formCompanie' => $form->createView(), 'controller_name' => 'AddArticleController',
        ));
    }


}
