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
     * @ORM\ManyToMany(targetEntity="Project", mappedBy="contacts")
     *
     */
    private $projects;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompanieEmployee", mappedBy="employee", cascade={"persist"})
     */
    private $companies;

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

    public function getProjects(): ?ArrayCollection
    {
        return $this->projects;
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

}
