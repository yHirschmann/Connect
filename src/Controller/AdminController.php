<?php

namespace App\Controller;


use App\Entity\Companies;
use App\Entity\Employee;
use App\Entity\Project;
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
        $companies = $this->getLatestCompanies();
        $projects = $this->getLatestProjects();
        $employees = $this->getLatestEmployees();
        return $this->render('admin/index.html.twig', [
            'companies' => $companies, 'projects' => $projects, 'employees' => $employees
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
            $user->setIsAllowed(true);
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

    private function getLatestCompanies(){
        return $this->getDoctrine()->getRepository(Companies::class)->createQueryBuilder('c')->orderBy('c.added_at', 'DESC')->setMaxResults(5)->getQuery()->execute();
    }

    private function getLatestProjects(){
        return $this->getDoctrine()->getRepository(Project::class)->createQueryBuilder('p')->orderBy('p.created_at', 'DESC')->setMaxResults(5)->getQuery()->execute();
    }

    private function getLatestEmployees(){
        return $this->getDoctrine()->getRepository(Employee::class)->createQueryBuilder('e')->orderBy('e.added_at',  'DESC')->setMaxResults(5)->getQuery()->execute();
    }
}
