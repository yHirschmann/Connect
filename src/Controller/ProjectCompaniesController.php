<?php

namespace App\Controller;

use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectCompaniesController extends AbstractController
{
    public function ProjectCompanies(Project $project)
    {
        $companies = $project->getCompanies();
        return $this->render(
            'project_companies/projectCompanie.html.twig',
            ['companies' => $companies]
        );
    }

    public function ProjectCompaniesEdit(Project $project){
        $companies = $project->getCompanies();
        return $this->render(
            'project_companies/projectCompanieEdit.html.twig',
            ['companies' => $companies]
        );
    }
}
