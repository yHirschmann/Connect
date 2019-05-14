<?php

namespace App\Controller;

use App\Entity\CompanieType;
use App\Entity\Project;
use App\Form\Type\EditProjectFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Twig\Environment;

class ProjectController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

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
        $companieTypes = $doctrine->getRepository(CompanieType::class)->findAll();
        return new Response($environment->render('project/project_details.html.twig', array('project' => $project, 'types' => $companieTypes)));
    }

    /**
     * @Route("/edit/project/{id}", name="_editProject")
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
        $this->denyAccessUnlessGranted('ROLE_USER');
        $doctrine = $this->getDoctrine();
        $project = $doctrine->getRepository(Project::class)->find($id);
        $companieTypes = $doctrine->getRepository(CompanieType::class)->findAll();

        $form = $this->createForm(EditProjectFormType::class, $project);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('added','Les informations ont bien été enregistré.');
            return $this->redirectToRoute('_project', ['id' => $id]);
        }
        return $this->render('project/editProject.html.twig', array(
            'project' => $project,
            'types' => $companieTypes,
            'editProject' => $form->createView()
        ));
    }
}
