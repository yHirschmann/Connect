<?php

namespace App\Controller;

use App\Entity\Companies;
use App\Entity\CompanieType;
use App\Entity\Employee;
use App\Entity\Project;
use App\Form\Type\AddCompanieType;
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
     * @Route("/ajouter" , name="_add")
     * @param Environment $environment
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function addArticleIndex()
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
            /** @var Companies $companie */
            $companie = $form->getData();
            $companie = $companie->formatCompaniePhoneNumber($companie);
            $companie = $companie->formatCompanieSocialReason($companie);

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
            foreach($contact->getCompanies() as $company){
                $company->setAddedBy($this->user);
            }
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
            $repository = $this->getDoctrine()->getRepository(CompanieType::class);
            $unexistingCompanies = $request->request->get('add_project')['unexistingCompanies'];
            $unexistingContact = $request->request->get('add_project')['unexistingContacts'];
            foreach ($unexistingCompanies as $company){
                if(!empty($company['companie_name'])){
                    $comp = new Companies();
                    $comp->setCompanieName($company['companie_name']);
                    $comp->setAdress($company['Adress']);
                    $comp->setPostalCode($company['postal_code']);
                    $comp->setCity($company['City']);
                    $comp->setPhoneNumber($company['phone_number']);
                    $comp->setTurnover($company['turnover']);
                    $comp->setSocialReason($company['social_reason']);
                    $comp->setType($repository->find(intval($company['type'])));
                    $project->addCompany($comp);
                    $entityManager->persist($comp);
                }
            }
            foreach($unexistingContact as $contact){
                if(!empty($contact['FirstName'])){
                    $employee = new Employee();
                    $employee->setFirstName($contact['FirstName']);
                    $employee->setLastName($contact['LastName']);
                    $employee->setEmail($contact['Email']);
                    $employee->setPhoneNumber($contact['phoneNumber']);
                    $project->addContact($employee);
                    $entityManager->persist($employee);
                }
            }
            //TODO manage the file upload
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
}
