<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\Project;
use App\Entity\ProjectFile;
use App\Form\Type\EditProjectFormType;
use DateTime;
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
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function projectsAction(Environment $environment){
        $this->denyAccessUnlessGranted('ROLE_USER');
        $projects = $this->getDoctrine()->getRepository(Project::class)->findAll();
        return new Response($environment->render('project/projects.html.twig', array('projects' => $projects)));
    }

    /**
     * @Route("/projet/{id}", name="_project")
     * @param Environment $environment
     * @param $id
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function projectAction(Environment $environment, $id){
        $this->denyAccessUnlessGranted('ROLE_USER');
        $doctrine = $this->getDoctrine();
        $project = $doctrine->getRepository(Project::class)->find($id);
        return new Response($environment->render('project/project_details.html.twig', array('project' => $project)));
    }

    /**
     * @Route("/edit/projet/{id}", name="_editProject")
     * @param Environment $environment
     * @param $id
     * @param ValidatorInterface $validator
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function editProjectAction(Environment $environment, $id, ValidatorInterface $validator, Request $request){
        $this->denyAccessUnlessGranted('ROLE_REGULAR');
        $entityManager = $this->getDoctrine()->getManager();
        $doctrine = $this->getDoctrine();

        $project = $doctrine->getRepository(Project::class)->find($id);

        $companies = new \ArrayObject();
        foreach($project->getCompanies() as $projectCompanies){
            $companies->append($projectCompanies->getCompanies());
        }

        $form = $this->createForm(EditProjectFormType::class, $project);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            /**
             * @var Project $project
             */
            $project = $form->getData();
            $project->setLastUpdateAt(new DateTime('NOW'));
            $project->setLastUpdateBy($this->getUser());

            foreach($project->getCompanies() as $companie ){
                if($companie->getProject() == null || $companie->getCompanies() == null ){
                    $project->removeCompany($companie);
                }
            }
            $project = $this->setUnexistingContact($request, $project, $entityManager);
            $project = $this->setUnexistingFiles($request, $project, $entityManager);

            $entityManager->persist($project);
            $entityManager->flush();
            $this->addFlash('added','Les informations ont bien été enregistré.');
            return $this->redirectToRoute('_project', ['id' => $id]);
        }

        return $this->render('project/editProject.html.twig', array('project' => $project, 'companies' => $companies, 'editProject' => $form->createView()));
    }

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

    private function setUnexistingFiles($request, $project, $entityManager){
        if(isset($request->files->get('edit_project_form')['newFiles'])) {
            $files = $request->files->get('edit_project_form')['newFiles'];

            foreach ($files as $file) {
                $file = $file['file']['file'];
                if(!empty($file)){
                    $projectFile = new ProjectFile();
                    $projectFile->setFile($file);
                    $projectFile->setFileOriginalName(str_replace(' ', '_', $file->getClientOriginalName()));
                    $projectFile->setAddedBy($this->getUser());
                    $project->addFile($projectFile);
                    $entityManager->persist($projectFile);
                }
            }
        }
        return $project;
    }
}