<?php

namespace App\Controller;

use App\Entity\Companies;
use DateTime;
use App\Entity\Employee;
use App\Form\Type\EditContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Twig\Environment;

/**
 * Class ContactController
 * @package App\Controller
 */
class ContactController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/contact", name="_contacts")
     * @param Environment $environment
     * @return Response
     */
    public function contactsAction(Environment $environment){
        $this->denyAccessUnlessGranted('ROLE_USER');

        //For the search redirection
        $formResponse = $this->forward('App\\Controller\\SearchController::searchBar');
        if($formResponse->isRedirection()) {
            return $formResponse;
        }
        return $this->render('contact/contacts.html.twig', [
            'form' => $formResponse,
            'contacts' => $this->initContactsPage()]);
    }

    /**
     * @Route("/contact/{id}", name="_contact")
     * @param Environment $environment
     * @param $id
     * @return Response
     */
    public function contactAction(Environment $environment, $id){
        $this->denyAccessUnlessGranted('ROLE_USER');

        //For the search redirection
        $formResponse = $this->forward('App\\Controller\\SearchController::searchBar');
        if($formResponse->isRedirection()) {
            return $formResponse;
        }

        $contact = $this->entityManager->getRepository(Employee::class)->find($id);
        return $this->render('contact/contact_details.html.twig', [
            'form' => $formResponse,
            'contact'=>$contact,
        ]);
    }

    /**
     * @Route("/edit/contact/{id}", name="_editContact")
     * @param Environment $environment
     * @param $id
     * @param ValidatorInterface $validator
     * @param Request $request
     * @throws
     * @return Response
     */
    public function editContactAction(Environment $environment, $id, ValidatorInterface $validator, Request $request){
        $this->denyAccessUnlessGranted('ROLE_REGULAR');

        //For the search redirection
        $formResponse = $this->forward('App\\Controller\\SearchController::searchBar');
        if($formResponse->isRedirection()) {
            return $formResponse;
        }

        $contact = $this->entityManager->getRepository(Employee::class)->find($id);

        $form = $this->createForm(EditContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            /** @var Employee $contact */
            $contact = $form->getData();
            $contact->setLastUpdateBy($this->getUser());
            $contact->setLastUpdateAt(new DateTime('NOW'));
            $this->entityManager->persist($contact);
            $this->entityManager->flush();
            $this->addFlash('added','Les informations ont bien été enregistré.');
            return $this->redirectToRoute('_contact', ['id' => $id]);
        }

        return $this->render('contact/editContact.html.twig', [
            'form' => $formResponse,
            'contact'=>$contact,
            'editContact' => $form->createView()
        ]);
    }

    /**
     * Get all contact in database
     * @return Companies[]|Employee[]|object[]
     */
    private function initContactsPage(){
        return $this->entityManager->getRepository(Employee::class)->findAll();
    }
}
