<?php

namespace App\Controller;

use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ProjectCompaniesController
 * @package App\Controller
 */
class ProjectCompaniesController extends AbstractController
{
    /**
     * @param Project $project
     * @return Response
     */
    public function ProjectCompanies(Project $project)
    {
        $companies = $project->getCompanies();
        return $this->render(
            'project_companies/projectCompanie.html.twig',
            ['companies' => $companies]
        );
    }

}
