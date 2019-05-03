<?php

namespace App\Controller;

use App\Entity\Companies;
use App\Entity\CompanieType;
use App\Entity\Employee;
use App\Entity\Project;
use App\Form\Type\AddCompanieType;
use App\Form\Type\AddCompanieTypeType;
use App\Form\Type\AddContactType;
use App\Form\Type\AddProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Twig\Environment;

class AddContactController extends AbstractController
{
    private $user;

    public function __construct()
    {
        $this->user = $this->getUser();;
    }

    /**
     * @Route("/ajouter/contact", name="_addContact")
     * @param ValidatorInterface $validator
     * @param Request $request
     * @return Response
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addContact(ValidatorInterface $validator,Request $request){
        $this->denyAccessUnlessGranted('ROLE_USER');
        $entityManager = $this->getDoctrine()->getManager();
        $contact = new Employee();

        $form = $this->createForm(AddContactType::class,$contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $contact = $form->getData();
            $contact->setAddedBy($this->getUser());
            $repository = $this->getDoctrine()->getRepository(Employee::class);
            $queryNames = $repository->findByExisting($contact->getLastName(), $contact->getFirstName());
            $queryEmail = $repository->findByEmail($contact->getEmail());

            if(empty($queryNames) && empty($queryEmail))
            {
                $entityManager->persist($contact);
                $entityManager->flush();
                $this->addFlash('added','Les informations ont bien été enregistré.');
                return $this->redirectToRoute('_addContact');
            }else{
                if(!empty($queryNames)){
                    $this->addFlash('existing','L\'email de ce contact existe déjà dans la base de donnée.');
                }
                elseif(!empty($queryEmail)){
                    $this->addFlash('existing','Ce contact existe déjà dans la base de donnée.');
                }else{
                    $this->addFlash('existing','Un problème est survenue lors de la requête, il se peut que le contact existe déjà.');
                }
                return $this->redirect($request->headers->get('referer'));
            }
        }
        return $this->render('form/AddContact.html.twig', array(
            'formContact' => $form->createView(),
            'controller_name' => 'AddArticleController',
        ));
    }

}
