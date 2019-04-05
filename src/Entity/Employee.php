<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeRepository")
 */
class Employee extends Person
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompanieEmployee", mappedBy="employee", cascade={"persist"})
     */
    private $companies;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Project", mappedBy="contacts")
     */
    private $projects;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->companies = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getLastName().' '.$this->getFirstName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return Collection|CompanieEmployee[]
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    public function addCompany(CompanieEmployee $company): self
    {
        if (!$this->companies->contains($company)) {
            $this->companies[] = $company;
            $company->setEmployee($this);
        }

        return $this;
    }

    public function removeCompany(CompanieEmployee $company): self
    {
        if ($this->companies->contains($company)) {
            $this->companies->removeElement($company);
            // set the owning side to null (unless already changed)
            if ($company->getEmployee() === $this) {
                $company->setEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->addContact($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->contains($project)) {
            $this->projects->removeElement($project);
            $project->removeContact($this);
        }

        return $this;
    }


}
