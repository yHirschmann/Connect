<?php

namespace App\Controller;

use App\Entity\Companies;
use App\Entity\Employee;
use App\Entity\Project;
use App\Entity\ProjectCompanies;
use App\Entity\ProjectFile;
use App\Form\Type\AddProjectType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddProjectController extends AbstractController
{
    /**
     * @Route("/ajouter/projet", name="_addProject")
     * @param ValidatorInterface $validator
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function addProject(ValidatorInterface $validator, Request $request){
        $this->denyAccessUnlessGranted('ROLE_REGULAR');
        $entityManager = $this->getDoctrine()->getManager();
        $project = new Project();

        $form = $this->createForm(AddProjectType::class, $project);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            /**
             * @var Project project
             */
            $project = $form->getData();
            $project->setCreatedBy($this->getUser());

            $project = $this->setProjectCompanies($project, $entityManager);
            $project = $this->setUnexistingContacts($request, $project, $entityManager);
            $project = $this->setProjectImage($request, $project, $entityManager);
            $project = $this->setProjectFiles($project, $entityManager);

            $entityManager->persist($project);

            $entityManager->flush();
            $this->addFlash('added','Les informations ont bien été enregistré.');
            return $this->redirectToRoute('_addProject');
        }
        return $this->render('form/AddProject.html.twig', array('formProject' => $form->createView(),'controller_name' => 'AddArticleController',));
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
            $employee->setPosition($contact['position']);
            $employee->setAddedBy($this->getUser());
            $companie = $this->getDoctrine()->getRepository(Companies::class)->find(intval($contact['companie']));
            $employee->setCompanie($companie);
            $project->addContact($employee);

            return $employee;
        }
        return null;
    }

    /**
     * @param Project $project
     * @param EntityManager $entityManager
     * @throws
     * @return Project
     */
    private function setProjectCompanies($project, $entityManager):Project{
        /**
         * @var Employee $contact
         */
        foreach ($project->getContacts() as $contact) {
            $companie = $contact->getCompanie();
            $projectCompanie = ProjectCompanies::creat($project, $companie);
            if($project->getMatchingExistingCompanies($projectCompanie->getCompanies())->isEmpty()){
                $project->addCompany($projectCompanie);
                $entityManager->persist($projectCompanie);
            }
        }
        return $project;
    }

    /**
     * @param Request $request
     * @param Project $project
     * @param EntityManager $entityManager
     * @throws
     * @return Project
     */
    private function setUnexistingContacts($request, $project, $entityManager):Project{
        $unexistingContact = $request->request->get('add_project')['unexistingContacts'];
        foreach ($unexistingContact as $contact) {
            $employee = $this->createNewContact($contact, $project);
            if ($employee !== null) {
                $companie = $employee->getCompanie();
                $entityManager->persist($employee);
                $companie->addEmployee($employee);

                $projectCompanie = ProjectCompanies::creat($project, $companie);
                $project->addCompany($projectCompanie);
                $entityManager->persist($projectCompanie);
            }
        }
        return $project;
    }

    /**
     * @param $request
     * @param $project
     * @param $entityManager
     * @return Project
     * @throws \Exception
     */
    private function setProjectImage($request, $project, $entityManager):Project {
        $image = $request->files->get('add_project')['file'][0]["file"]["file"];
        if($image != null){
            $projectImage = new ProjectFile();
            $projectImage->setFile($image);
            $projectImage->setIsProjectImage(true);
            $project->addFile($projectImage);
            $entityManager->persist($projectImage);
        }
        return $project;
    }

    /**
     * @param Project $project
     * @param EntityManager $entityManager
     * @throws
     * @return Project
     */
    private function setProjectFiles($project, $entityManager){
        $files = $project->getFiles();

        /** @var ProjectFile $file */
        foreach($files as $file){
            $file->setFileOriginalName(str_replace(' ', '_', $file->getFile()->getClientOriginalName()));
            $existingFile = $entityManager->getRepository(ProjectFile::class)->findOneByFileOriginalName($file->getFileOriginalName());

            if($existingFile == null && $project->getMatchingExistingFiles($file->getFile())->count() == 1){
                $file->setAddedBy($this->getUser());
                $entityManager->persist($file);
            }else{
                $project->removeFile($file);
                $this->addFlash('existing','le fichier nommé : '.$file->getFileOriginalName().' existe déjà, doublon suprimé');
            }
        }
        return $project;
    }
}
