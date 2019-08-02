<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\ForgottenPasswordType;
use App\Form\Type\RegistrationFormType;
use App\Form\Type\ResetPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security\login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/mon-compte/oublie", name="_forgotten-psw")
     * @param ValidatorInterface $validator
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @param TokenGeneratorInterface $tokenGenerator
     * @return RedirectResponse|Response
     */
    public function forgotPassword(ValidatorInterface $validator,Request $request, \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator){
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(ForgottenPasswordType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $email = $request->get('forgotten_password')['UserMail'];

            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);

            if(!$user == null) {
                $token = $tokenGenerator->generateToken();

                $user->setResetToken($token);
                $entityManager->persist($user);
                $entityManager->flush();

                $url = $this->generateUrl('_reset-psw', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

                $message = (new \Swift_Message('Mot de passe oublié'))
                    ->setFrom('hirschmann.yann.bts.sio@gmail.com')
                    ->setTo($email)
                    ->setBody(
                        $this->renderView(
                            'emails/forgotten_pswd_email.html.twig',
                            ['url' => $url, 'user' => $user ]
                        ),
                        'text/html'
                    );
                $mailer->send($message);
            }else{
                $this->addFlash('danger','Email inconnue');
                return $this->redirectToRoute('_forgotten-psw');
            }
        }
        return $this->render('security/forgotten-pswd.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/reinitialiser-mot-de-passe/{token}", name="_reset-psw")
     * @param Request $request
     * @param string $token
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder){
        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(User::class)->findOneByResetToken($token);
        $form = $this->createForm(ResetPasswordType::class);

        $form->handleRequest($request);
        if(!$user == null){
            if($form->isSubmitted() && $form->isValid()){
                /*** @var User $user */
                $user->setResetToken(null);
                $user->setPassword($passwordEncoder->encodePassword(
                    $user,
                    $request->get('reset_password')['password']['first']
                ));

                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('notice', 'Mot de passe mis à jour');
                return $this->redirectToRoute('app_login');
            }
        }else{
            $this->addFlash('danger', 'Token Inconnu');
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/reset-pswd.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("creation-compte/{token}", name="_create_account")
     * @param Request $request
     * @param string $token
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function createAccount(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder){
        if(substr($token,-13) == '=Registration'){
            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->findOneByResetToken($token);

            $form = $this->createForm(RegistrationFormType::class);

            $form->handleRequest($request);
            if($user != null){
                if($form->isSubmitted() && $form->isValid()){
                    /*** @var User $user */
                    $user->setResetToken(null);
                    $user->setPassword($passwordEncoder->encodePassword(
                        $user,
                        $request->get('registration_form')['password']['first']
                    ));
                    $entityManager->persist($user);
                    $entityManager->flush();

                    $this->addFlash('notice', 'Inscription complété, vous pouvez vous connecter');
                    return $this->redirectToRoute('app_login');
                }
            }
            return $this->render('security/registration.html.twig', ['form' => $form->createView()]);
        }
        return $this->redirectToRoute('app_login');
    }

}
