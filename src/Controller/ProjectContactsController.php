<?php

namespace App\Controller;

use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ProjectContactsController
 * @package App\Controller
 */
class ProjectContactsController extends AbstractController
{
    /**
     * @param Project $project
     * @return Response
     */
    public function ProjectContacts(Project $project)
    {
        $contacts = $project->getContacts();
        return $this->render(
            'project_contacts/projectContact.html.twig',
            ['contacts' => $contacts]
        );
    }

}
