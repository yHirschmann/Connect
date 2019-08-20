<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\Project;
use App\Entity\ProjectFile;
use App\Form\Type\EditProjectFormType;
use DateTime;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Twig\Environment;

class ProjectController extends AbstractController
{

    /**
     * @Route("/projet", name="_projects")
     * @param Environment $environment
     * @return Response
     */
    public function projectsAction(Environment $environment){
        $this->denyAccessUnlessGranted('ROLE_USER');

        $formResponse = $this->forward('App\\Controller\\SearchController::searchBar');
        if($formResponse->isRedirection()) {
            return $formResponse; // just the redirection, no content
        }

        $projects = $this->getDoctrine()->getRepository(Project::class)->findAll();
        return $this->render('project/projects.html.twig', [
            'form' => $formResponse,
            'projects' => $projects
        ]);
    }

    /**
     * @Route("/projet/{id}", name="_project")
     * @param Environment $environment
     * @param $id
     * @return Response
     */
    public function projectAction(Environment $environment, $id){
        $this->denyAccessUnlessGranted('ROLE_USER');

        $formResponse = $this->forward('App\\Controller\\SearchController::searchBar');
        if($formResponse->isRedirection()) {
            return $formResponse; // just the redirection, no content
        }

        $doctrine = $this->getDoctrine();
        $project = $doctrine->getRepository(Project::class)->find($id);
        return $this->render('project/project_details.html.twig', [
            'form' => $formResponse,
            'project' => $project
        ]);
    }

    /**
     * @Route("/edit/projet/{id}", name="_editProject")
     * @param Environment $environment
     * @param $id
     * @param ValidatorInterface $validator
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function editProjectAction(Environment $environment, $id, ValidatorInterface $validator, Request $request){
        $this->denyAccessUnlessGranted('ROLE_REGULAR');

        $formResponse = $this->forward('App\\Controller\\SearchController::searchBar');
        if($formResponse->isRedirection()) {
            return $formResponse; // just the redirection, no content
        }

        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();

        $project = $doctrine->getRepository(Project::class)->find($id);

        $companies = new \ArrayObject();
        foreach($project->getCompanies() as $projectCompanies){
            $companies->append($projectCompanies->getCompanies());
        }

        $form = $this->createForm(EditProjectFormType::class, $project);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            /** @var Project $project */
            $project = $form->getData();
            $project->setLastUpdateAt(new DateTime('NOW'));
            $project->setLastUpdateBy($this->getUser());

            foreach($project->getCompanies() as $companie ){
                if($companie->getProject() == null || $companie->getCompanies() == null ){
                    $project->removeCompany($companie);
                }
            }
            $project = $this->updateProjectFiles($request, $project, $doctrine);
            $project = $this->setUnexistingContact($request, $project, $entityManager);
            $entityManager->persist($project);
            $entityManager->flush();
            $this->addFlash('added','Les informations ont bien été enregistré.');
            return $this->redirectToRoute('_project', ['id' => $id]);
        }

        return $this->render('project/editProject.html.twig', [
            'form' => $formResponse,
            'project' => $project,
            'companies' => $companies,
            'editProject' => $form->createView()
        ]);
    }

    /**
     * @param $request
     * @param $project
     * @param $entityManager
     * @return mixed
     */
    private function setUnexistingContact($request, $project, $entityManager){
        if(isset($request->request->get('edit_project_form')['newContacts'])){
            $unexistingContact = $request->request->get('edit_project_form')['newContacts'];

            foreach ($unexistingContact as $contact) {
                $employee = $this->getDoctrine()->getRepository(Employee::class)->find($contact);
                if($project->getMatchingExistingContacts($employee)->isEmpty()){
                    $project->addContact($employee);
                }
            }
        }

        return $project;
    }

    /**
     * Check if the file does not already exist in the database, transform data and add it to the project
     * @param $file
     * @param Project $project
     * @param $entityManager
     * @return Project
     * @throws \Exception
     */
    private function setUnexistingFiles($file ,Project $project, $entityManager){
        $file = $file['file']['file'];
        if($file != null){
            $fileName = str_replace(' ', '_', $file->getClientOriginalName());
            $existingFile = $entityManager->getRepository(ProjectFile::class)->findOneByFileOriginalName($fileName);
            if($existingFile == null && $project->getMatchingExistingFiles($file)->count() == 0) {
                $projectFile = new ProjectFile();
                $projectFile->setFile($file);
                $projectFile->setAddedBy($this->getUser());
                $entityManager->persist($projectFile);
                $projectFile->setFileOriginalName($fileName);
                $project->addFile($projectFile);

            }
        }
        return $project;
    }

    /**
     * @param Request $request
     * @param Project $project
     * @param ManagerRegistry $doctrine
     * @return Project
     * @throws \Exception
     */
    private function updateProjectFiles(Request $request, Project $project, ManagerRegistry $doctrine){

        $arrayKey = array_key_first($request->files->get('edit_project_form')['newFiles']);
        if(!empty($request->files->get('edit_project_form')['newFiles'][$arrayKey]['file']['file'])) {
            $unexistingFiles = $request->files->get('edit_project_form')['newFiles'];
            foreach($unexistingFiles as $file){
                $project = $this->setUnexistingFiles($file, $project, $doctrine->getManager());
            }
        }

        /**
         * @var ProjectFile $currentProjectImage
         */
        $projectfiles = $doctrine->getRepository(ProjectFile::class)->getProjectImageById($project->getId());
        if(!empty($projectfiles)){
            $currentProjectImage = $doctrine->getRepository(ProjectFile::class)->getProjectImageById($project->getId())[0];

            /**
             * @var string $currentProjectImageCheckBox
             * 'true' or null
             */
            $currentProjectImageCheckBox = $request->request->get('isImageCheckBox'.$currentProjectImage->getId());

            $files = $project->getFiles();
            foreach($files as $file){
                $fileId = $file->getId();
                if($fileId == null){
                    $key = 'isImageCheckBox'.$file->getFileOriginalName();
                    $key = substr_replace($key,'_',strpos($key,'.'), 1);
                    $isProjectImage = $request->request->get($key);
                }else{
                    $isProjectImage = $request->request->get('isImageCheckBox'.$fileId);
                }
                if ($isProjectImage != null){
                    if($currentProjectImage == null || $currentProjectImageCheckBox != 'true'){
                        $file->setIsProjectImage(true);
                    }elseif($currentProjectImage != $file){
                        $this->addFlash('existing','le fichier '.$file->getFileOriginalName().' n\'a pas put être défini comme Image du projet, une autre image est déjà définie');
                    }
                }elseif($isProjectImage == null){
                    $file->setIsProjectImage(false);
                }
            }
        }


        return $project;
    }
}