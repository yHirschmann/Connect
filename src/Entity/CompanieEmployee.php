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
    private $enter_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $out_at;

    public function __construct()
    {
        $this->out_at = new \DateTime('9999-1-1');
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

    public function getEnterAt(): ?\DateTimeInterface
    {
        return $this->enter_at;
    }

    public function setEnterAt(\DateTimeInterface $enter_at): self
    {
        $this->enter_at = $enter_at;

        return $this;
    }

    public function getOutAt(): ?\DateTimeInterface
    {
        return $this->out_at;
    }

    public function setOutAt(\DateTimeInterface $out_at): self
    {
        $this->out_at = $out_at;

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
}
