<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserEditType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Twig\Environment;

class MainController extends AbstractController
{


    /**
     * @Route("/", name="_index")
     * @param Environment $environment
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function indexAction(Environment $environment){
        $this->denyAccessUnlessGranted('ROLE_USER');
        return new Response($environment->render('pages/index.html.twig'));
    }

    /**
     * @Route("/mon-compte", name="_account")
     * @param UserPasswordEncoderInterface $encoder
     * @param ValidatorInterface $validator
     * @param Request $request
     * @return Response
     */
    public function accountAction(UserPasswordEncoderInterface $encoder,ValidatorInterface $validator,Request $request){
        $this->denyAccessUnlessGranted('ROLE_USER');
        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(UserEditType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $userEdit = $request->request->get('user_edit');
            $email = $userEdit['email'];
            if($email !== ""){
                if($email !== $user->getEmail()){
                    $user->setEmail($email);
                    $entityManager->persist($user);
                    $this->addFlash('added','Email correctement modifié');
                }else{
                    $this->addFlash('warning','Email identique');
                }
            }

            $phoneNum = $userEdit['phone_number'];
            if($phoneNum !== ""){
                if($phoneNum !== $user->getPhoneNumber()){
                    $user->setPhoneNumber($phoneNum);
                    $entityManager->persist($user);
                    $this->addFlash('added','Numéro de téléphone correctement modififé');
                }else{
                    $this->addFlash('warning','Numéro de téléphone identique');
                }
            }

            $password = $userEdit['password'];
            $confirmPassword = $userEdit['confirmPassword'];
            if($password !== "" && $confirmPassword !== "" && $password === $confirmPassword){
                $encodedPass = $encoder->encodePassword($user, $password);

                if($encodedPass !== $user->getPassword()){
                    $user->setPassword($encodedPass);
//                    $entityManager->persist($user);
//                    $this->addFlash('added','Mot de passe correctement modififé');
                }else{
                    $this->addFlash('warning','Mot de passe identique');
                }
            }


        }
        return $this->render('pages/account.html.twig', array(
            'form'=> $form->createView(),
            'user' => $user
        ));

    }
}
