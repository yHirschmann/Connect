<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\Type\AddContactType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AddContactController
 * Controller the addContactForm, Allow users to add new Contact/Employee in the database
 * @package App\Controller
 */
class AddContactController extends AbstractController
{

    /**
     * @Route("/ajouter/contact", name="_addContact")
     * @param ValidatorInterface $validator
     * @param Request $request
     * @return Response
     * @return RedirectResponse|Response
     */
    public function addContact(ValidatorInterface $validator,Request $request){
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

        $contact = new Employee();

        $form = $this->createForm(AddContactType::class,$contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            /** @var Employee $contact */
            $contact = $form->getData();
            $contact->setAddedBy($this->getUser());
            $phoneNumber = $contact->getPhoneNumber();
            $phoneNumber = str_replace(array(' ','.','-'),"",$phoneNumber);
            $contact->setPhoneNumber($phoneNumber);

            $repository = $doctrine->getRepository(Employee::class);
            $queryNames = $repository->findByExisting($contact->getLastName(), $contact->getFirstName());
            $queryEmail = $repository->findByEmail($contact->getEmail());

            //if contact do not exist (name + email), persist the contact and flush it
            if(empty($queryNames) && empty($queryEmail))
            {
                $entityManager->persist($contact);
                $entityManager->flush();

                $this->addFlash('added','Les informations ont bien été enregistré.');
                return $this->redirectToRoute('_addContact');
            }else{
                if(!empty($queryEmail)){
                    $this->addFlash('existing','L\'email de ce contact existe déjà dans la base de donnée.');
                }
                elseif(!empty($queryNames)){
                    $this->addFlash('existing','Ce contact existe déjà dans la base de donnée.');
                }else{
                    $this->addFlash('existing','Un problème est survenue lors de la requête, il se peut que le contact existe déjà.');
                }
                return $this->redirect($request->headers->get('referer'));
            }
        }
        return $this->render('form/AddContact.html.twig', [
            'form' => $formResponse,
            'formContact' => $form->createView(),
            'controller_name' => 'AddArticleController',
        ]);
    }
}
