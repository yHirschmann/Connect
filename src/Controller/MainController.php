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

/**
 * Class MainController
 * @package App\Controller
 */
class MainController extends AbstractController
{


    /**
     * @Route("/", name="_index")
     * @param Environment $environment
     * @return Response
     */
    public function indexAction(Environment $environment){
        $this->denyAccessUnlessGranted('ROLE_USER');
        $formResponse = $this->forward('App\\Controller\\SearchController::searchBar');
        if($formResponse->isRedirection()) {
            return $formResponse; // just the redirection, no content
        }
        return $this->render('pages/index.html.twig', [
            'form' => $formResponse
        ]);
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

        //For the search redirection
        $formResponse = $this->forward('App\\Controller\\SearchController::searchBar');
        if($formResponse->isRedirection()) {
            return $formResponse;
        }

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
            $oldPassword = $userEdit['oldPassword'];
            if($password !== ""){
                $newPassword = $password['first'];
                if($encoder->isPasswordValid($user, $oldPassword)){
                    if(!$encoder->isPasswordValid($user, $newPassword)){
                        $encodedPass = $encoder->encodePassword($user, $newPassword);
                        $user->setPassword($encodedPass);
                        $entityManager->persist($user);
                        $this->addFlash('added','Mot de passe correctement modififé');

                    }else{
                        $this->addFlash('warning','Le nouveau mot de passe doit être different de l\'ancien');
                    }
                }
            }

            $entityManager->flush();

            return $this->render('pages/account.html.twig', array(
                'form' => $formResponse,
                'formAccount'=> $form->createView(),
                'user' => $user
            ));
        }
        return $this->render('pages/account.html.twig', [
            'form' => $formResponse,
            'formAccount'=> $form->createView(),
            'user' => $user
        ]);

    }
}
