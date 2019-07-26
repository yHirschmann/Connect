<?php

namespace App\Controller;

use App\Entity\Companies;
use App\Entity\CompanieType;
use App\Form\Type\EditCompanieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Twig\Environment;
use DateTime;

class CompanieController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/entreprise", name="_companies")
     * @param Environment $environment
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function companiesAction(Environment $environment){
        $this->denyAccessUnlessGranted('ROLE_USER');
        return new Response($environment->render('companie/companies.html.twig', array('companies' => $this->initCompaniePage())));
    }

    /**
     * @Route("/entreprise/{id}", name="_companie")
     * @param Environment $environment
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function companieAction(Environment $environment, $id){
        $this->denyAccessUnlessGranted('ROLE_USER');
        $doctrine = $this->getDoctrine();
        $companie = $doctrine->getRepository(Companies::class)->findOneById($id);
        dump($companie->getProject());
        return new Response($environment->render('companie/companie_details.html.twig', array('companie' => $companie)));
    }

    /**
     * @Route("/edit/entreprise/{id}", name="_editCompanie")
     * @param Environment $environment
     * @param $id
     * @param ValidatorInterface $validator
     * @param Request $request
     * @throws
     * @return Response
     */
    public function editCompanieAction(Environment $environment, $id, ValidatorInterface $validator, Request $request){
        $this->denyAccessUnlessGranted('ROLE_REGULAR');
        $companie = $this->entityManager->getRepository(Companies::class)->find($id);

        $form = $this->createForm(EditCompanieType::class, $companie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $companie = $form->getData();
            $companie = $this->setUnexistingType($request, $companie);

            $companie->setLastUpdateAt(new DateTime('now'));
            $companie->setLastUpdateBy($this->getUser());

            $this->entityManager->persist($companie);
            $this->entityManager->flush();
            $this->addFlash('added','Les informations ont bien été enregistré.');
            return $this->redirectToRoute('_companie', ['id' => $id]);
        }
        return $this->render('companie/editCompanie.html.twig', array('companie' => $companie,'editCompanie' => $form->createView()));
    }

    private function initCompaniePage(){
        return $this->entityManager->getRepository(Companies::class)->findAll();
    }

    /**
     * @param Request $request
     * @param Companies $companie
     * @return Companies|null
     */
    private function setUnexistingType(Request $request, Companies $companie):?Companies{
        $unexistingType = $request->request->get('edit_companie')['unexistingType']["label"];
        if($unexistingType != null){
            $newType = new CompanieType();
            $newType->setLabel($unexistingType);
            $repository = $this->getDoctrine()->getRepository(CompanieType::class);
            if(!$repository->findByLabel($newType->getLabel())){
                $this->entityManager->persist($newType);
                $companie->setType($newType);
            }
        }
        return $companie;
    }
}
