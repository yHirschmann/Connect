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

class AddArticleController extends AbstractController
{
    private $user;

    public function __construct(Security $security)
    {
        $this->user = $security->getUser();;
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

    /**
     * @Route("/ajouter/projet", name="_addProject")
     * @param ValidatorInterface $validator
     * @param Request $request
     * @return Response
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addProject(ValidatorInterface $validator, Request $request){
        $this->denyAccessUnlessGranted('ROLE_USER');
        $entityManager = $this->getDoctrine()->getManager();
        $project = new Project();

        $form = $this->createForm(AddProjectType::class, $project);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $project = $form->getData();
            //TODO unexisting contact not registering on submitting project form
            $repository = $this->getDoctrine()->getRepository(CompanieType::class);
            $unexistingContact = $request->request->get('add_project')['unexistingContacts'];

            foreach($unexistingContact as $contact){
                $employee = $this->createNewContact($contact, $project);
                if($employee != null){
                    $entityManager->persist($employee);
                    $companie = $employee->getCompanie();
                    $companie->addEmployee($employee);
                    $project->addCompany($companie);
                }
            }

            //TODO manage multiple uploads
            $project->setCreatedBy($this->user);
            $entityManager->persist($project);
            $entityManager->flush();
            $this->addFlash('added','Les informations ont bien été enregistré.');
            return $this->redirectToRoute('_addProject');
        }

        return $this->render('form/AddProject.html.twig', array(
            'formProject' => $form->createView(),
            'controller_name' => 'AddArticleController',
        ));
    }

    /**
     * @param Employee $contact
     * @param Project $project
     * @return Employee
     */
    private function createNewContact($contact, $project){
        if(!empty($contact['FirstName'])){
            $employee = new Employee();
            $employee->setFirstName($contact['FirstName']);
            $employee->setLastName($contact['LastName']);
            $employee->setEmail($contact['Email']);
            $employee->setPhoneNumber($contact['phoneNumber']);
            $employee->setAddedBy($this->getUser());
            $companie = $this->getDoctrine()->getRepository(Companies::class)->find(intval($contact['companie']));
            $employee->setCompanie($companie);

            $project->addContact($employee);

            return $employee;
        }
    }
}
