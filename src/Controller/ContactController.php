<?php

namespace App\Controller;


use App\Entity\Employee;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
    public function contactAction(Environment $environment){
        $this->denyAccessUnlessGranted('ROLE_USER');

        return new Response($environment->render('contact/contact_details.html.twig'));
    }

    private function initContactsPage(){
        return $this->entityManager->getRepository(Employee::class)->findAll();
    }
}
