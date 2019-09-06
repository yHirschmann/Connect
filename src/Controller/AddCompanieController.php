<?php

namespace App\Controller;

use DateTime;
use App\Entity\Companies;
use App\Entity\CompanieType;
use App\Form\Type\AddCompanieType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AddCompanieController
 * Controller the addCompanieForm, Allow users to add new Companie in the database
 * @package App\Controller
 *
 */
class AddCompanieController extends AbstractController
{
    /**
     * @Route("/ajouter/entreprise" , name="_addCompanie")
     * @param ValidatorInterface $validator
     * @param Request $request
     *
     * @throws
     * @return Response
     */
    public function addCompanie(ValidatorInterface $validator,Request $request){
        $this->denyAccessUnlessGranted('ROLE_REGULAR');

        //Handle the redirection of the search controller
        $formResponse = $this->forward('App\\Controller\\SearchController::searchBar');
        if($formResponse->isRedirection()) {
            return $formResponse; // just the redirection, no content
        }

        /** @var ManagerRegistry $doctrine */
        $doctrine = $this->getDoctrine();

        /** @var ObjectManager $entityManager */
        $entityManager = $doctrine->getManager();

        $companie = new Companies();

        $form = $this->createForm(AddCompanieType::class,$companie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            /** @var Companies $companie */
            $companie = $form->getData();
            $companie = $companie->formatCompaniePhoneNumber($companie);
            $companie = $companie->formatCompanieSocialReason($companie);
            $companie->setAddedBy($this->getUser());
            $companie->setAddedAt(new DateTime('now'));

            //Get the unexistringType
            $unexistingType = $request->request->get('add_companie')['unexistingType']["label"];

            //if unexistringType is set, create a new companieType
            if(!empty($unexistingType)){
                $newType = new CompanieType();
                $newType->setLabel($unexistingType);
                $repository = $doctrine->getRepository(CompanieType::class);

                //if the new type do not exist, persist the newType
                if(!$repository->findByLabel($newType->getLabel())){
                    $entityManager->persist($newType);
                }
                $companie->setType($newType);
            }

            $companies = $doctrine->getRepository(Companies::class)
                                    ->findByExisting($companie->getCompanieName(), $companie->getCity(), $companie->getAdress());

            //If the companie do not already exist (similar name, city and adress), persist all and flush
            if(empty($companies)){
                $entityManager->persist($companie);
                $entityManager->flush();

                $this->addFlash('added','Les informations ont bien été enregistré.');
                return $this->redirectToRoute("_addCompanie");
            }else{
                $this->addFlash('existing','Cette entreprise existe déjà dans la base de donnée.');
                return $this->redirect($request->headers->get('referer'));
            }
        }

        return $this->render('form/AddCompanie.html.twig', [
            'form' => $formResponse,
            'formCompanie' => $form->createView(),
        ]);
    }
}
