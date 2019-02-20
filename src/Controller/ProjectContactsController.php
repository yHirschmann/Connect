<?php

namespace App\Controller;

use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectContactsController extends AbstractController
{
    public function ProjectContacts(Project $project)
    {
        $contacts = $project->getContacts();
        return $this->render(
            'project_contacts/projectContact.html.twig',
            ['contacts' => $contacts]
        );
    }
}
