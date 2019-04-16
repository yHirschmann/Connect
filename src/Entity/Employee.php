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
     * @ORM\ManyToMany(targetEntity="App\Entity\Project", mappedBy="contacts")
     */
    private $projects;

    /**
     * @ORM\Column(type="datetime")
     */
    private $added_at;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Companies", inversedBy="employees")
     * @ORM\JoinColumn(nullable=false)
     */
    private $companie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="employees_added")
     * @ORM\JoinColumn(nullable=false)
     */
    private $added_by;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->added_at = \DateTime::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s'));
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

    public function getCompanie(): ?Companies
    {
        return $this->companie;
    }

    public function setCompanie(?Companies $companie): self
    {
        $this->companie = $companie;
        return $this;
    }

    public function getAddedAt(){
        return $this->added_at;
    }

    public function getAddedBy(): ?user
    {
        return $this->added_by;
    }

    public function setAddedBy(?user $added_by): self
    {
        $this->added_by = $added_by;

        return $this;
    }

}
