<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectCompaniesRepository")
 */
class ProjectCompanies
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="companies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Companies", inversedBy="project")
     * @ORM\JoinColumn(nullable=false)
     */
    private $companies;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $gotProject;

    /**
     * @param Project $project
     * @param Companies $companie
     * @return ProjectCompanies|null
     */
    public static function creat($project, $companie): ?ProjectCompanies{
        $instance = new self();
        $instance->setCompanies($companie);
        $instance->setProject($project);
        return $instance;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getCompanies(): ?Companies
    {
        return $this->companies;
    }

    public function setCompanies(?Companies $companies): self
    {
        $this->companies = $companies;

        return $this;
    }

    public function getGotProject(): ?bool
    {
        return $this->gotProject;
    }

    public function setGotProject(?bool $gotProject): self
    {
        $this->gotProject = $gotProject;

        return $this;
    }

}
