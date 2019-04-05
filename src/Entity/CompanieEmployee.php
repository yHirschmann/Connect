<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompanieEmployeeRepository")
 */
class CompanieEmployee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Employee", inversedBy="companies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $employee;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Companies", inversedBy="employees")
     * @ORM\JoinColumn(nullable=false)
     */
    private $companie;

    /**
     * @ORM\Column(type="datetime")
     */
    private $added_at;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="employees_added")
     * @ORM\JoinColumn(nullable=false)
     */
    private $added_by;

    public function __construct()
    {
        $this->out_at = new \DateTime('9999-1-1');
        $this->added_at = new \DateTime("now");
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getAddedAt(): ?\DateTimeInterface
    {
        return $this->added_at;
    }

    public function setAddedAt(\DateTimeInterface $added_at): self
    {
        $this->added_at = $added_at;

        return $this;
    }

    public function getAddedBy(): ?User
    {
        return $this->added_by;
    }

    public function setAddedBy(?User $added_by): self
    {
        $this->added_by = $added_by;

        return $this;
    }
}
