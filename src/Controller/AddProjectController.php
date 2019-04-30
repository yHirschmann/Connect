<?php

namespace App\Controller;

use App\Entity\Companies;
use App\Entity\Employee;
use App\Entity\Project;
use App\Form\Type\AddProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddProjectController extends AbstractController
{
    private $user;

    public function __construct(Security $security)
    {
        $this->user = $security->getUser();;
    }

    //TODO manage multiple uploads
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

        if($form->isSubmitted() && $form->isValid()) {
            $project = $form->getData();
            $project->setCreatedBy($this->user);
            /**
             * @var Employee $contact
             */
            foreach ($project->getContacts() as $contact) {
                $companie = $contact->getCompanie();
                $project->addCompany($companie);
            }
            $unexistingContact = $request->request->get('add_project')['unexistingContacts'];
            foreach ($unexistingContact as $contact) {
                $employee = $this->createNewContact($contact, $project);
                if ($employee != null) {
                    $entityManager->persist($employee);
                    $companie = $employee->getCompanie();
                    $companie->addEmployee($employee);
                    $project->addCompany($companie);
                }
            }
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
