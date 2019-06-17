<?php

namespace App\Controller;

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
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function contactsAction(Environment $environment){
        $this->denyAccessUnlessGranted('ROLE_USER');
        return new Response($environment->render('contact/contacts.html.twig', array('contacts' => $this->initContactsPage())));
    }

    /**
     * @Route("/contact/{id}", name="_contact")
     * @param Environment $environment
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function contactAction(Environment $environment, $id){
        $this->denyAccessUnlessGranted('ROLE_USER');
        $contact = $this->entityManager->getRepository(Employee::class)->find($id);
        return new Response($environment->render('contact/contact_details.html.twig', array('contact'=>$contact)));
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
        $this->denyAccessUnlessGranted('ROLE_USER');
        $contact = $this->entityManager->getRepository(Employee::class)->find($id);

        $form = $this->createForm(EditContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            /**
             * @var Employee $contact
             */
            $contact = $form->getData();
            $contact->setLastUpdateBy($this->getUser());
            $contact->setLastUpdateAt(new DateTime('NOW'));
            $this->entityManager->persist($contact);
            $this->entityManager->flush();
            $this->addFlash('added','Les informations ont bien été enregistré.');
            return $this->redirectToRoute('_contact', ['id' => $id]);
        }
        return $this->render('contact/editContact.html.twig', array(
            'contact'=>$contact, 'editContact' => $form->createView()
        ));
    }

    private function initContactsPage(){
        return $this->entityManager->getRepository(Employee::class)->findAll();
    }
}
