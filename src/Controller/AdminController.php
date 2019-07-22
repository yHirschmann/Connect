<?php

namespace App\Controller;


use App\Entity\User;
use Doctrine\ORM\EntityManager;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController as BaseAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\UriSafeTokenGenerator;

class AdminController extends BaseAdminController
{

    /** @var array The full configuration of the entire backend */
    protected $config;
    /** @var array The full configuration of the current entity */
    protected $entity;
    /** @var Request The instance of the current Symfony request */
    protected $request;
    /** @var EntityManager The Doctrine entity manager for the current entity */
    protected $em;

    /**
     * @Route("/dashboard", name="admin_dashboard")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    public function createNewUserEntity()
    {
        $userValues = $this->request->request->get('user');
        $role = $this->request->request->get('user_roles');
        $user = new User();
        if($userValues != null){
            $email = $userValues['email'];

            $user->setFirstName($userValues['first_name']);
            $user->setLastName($userValues['last_name']);
            $user->setPhoneNumber($userValues['phone_number']);
            switch ($role){
                case 0:
                    $user->setRoles(['ROLE_USER']);
                    break;
                case 1:
                    $user->setRoles(['ROLE_USER', 'ROLE_REGULAR']);
                    break;
                case 2:
                    $user->setRoles(['ROLE_USER', 'ROLE_REGULAR', 'ROLE_ADMIN']);
                    break;
                default:
                    $user->setRoles(['ROLE_USER']);
            }
            $user->setEmail($email);
            $user->setPassword(md5(random_bytes(64)));

            $tokenGenerator = new UriSafeTokenGenerator();
            $token = $tokenGenerator->generateToken();
            $token .= '=Registration';
            $user->setResetToken($token);

            $url = $this->generateUrl('_create_account', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);
            $transporter = (new \Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
                ->setUsername('hirschmann.yann.bts.sio@gmail.com')
                ->setPassword('Glgtlmde8a9');

            $mailer = new \Swift_Mailer($transporter);

            $message = (new \Swift_Message('Inscription'))
                ->setFrom('hirschmann.yann.bts.sio@gmail.com')
                ->setTo($email)
                ->setBody(
                    $this->renderView(
                        'emails/registration.html.twig',
                        ['url' => $url, 'user' => $user]
                    ),
                    'text/html'
                );

            $mailer->send($message);
        }
        return $user;
    }
}
