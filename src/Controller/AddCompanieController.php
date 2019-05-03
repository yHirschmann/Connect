<?php

namespace App\Controller;

use App\Entity\Companies;
use App\Entity\CompanieType;
use App\Form\Type\AddCompanieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddCompanieController extends AbstractController
{
    private $user;

    public function __construct()
    {
        $this->user = $this->getUser();;
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
            /** @var Companies $companie */
            $companie = $form->getData();
            $companie = $companie->formatCompaniePhoneNumber($companie);
            $companie = $companie->formatCompanieSocialReason($companie);
            $unexistingType = $request->request->get('add_companie')['unexistingType']["label"];

            if(!empty($unexistingType)){
                $newType = new CompanieType();
                $newType->setLabel($unexistingType);
                $repository = $this->getDoctrine()->getRepository(CompanieType::class);
                if(!$repository->findByLabel($newType->getLabel())){
                    $entityManager->persist($newType);
                }
            }
            if(is_null($companie->getType())){
                $companie->setType($newType);
            }

            if(empty($this  ->getDoctrine()
                ->getRepository(Companies::class)
                ->findByExisting($companie->getCompanieName(),$companie->getCity(),$companie->getAdress())))
            {
                $entityManager->persist($companie);
                $entityManager->flush();
                $this->addFlash('added','Les informations ont bien été enregistré.');
                return $this->redirectToRoute("_addCompanie");
            }else{
                $this->addFlash('existing','Cette entreprise existe déjà dans la base de donnée.');
                return $this->redirect($request->headers->get('referer'));
            }

        }

        return $this->render('form/AddCompanie.html.twig', array(
            'formCompanie' => $form->createView(),
            'controller_name' => 'AddArticleController',
        ));
    }

}
