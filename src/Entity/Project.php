<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $project_name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $started_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $ended_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress;

    /**
     * @ORM\Column(type="integer")
     */
    private $postal_code;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cost;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $img_path;

    /**
     * @ORM\ManyToMany(targetEntity="Employee", inversedBy="projects")
     * @ORM\JoinTable(name="projects_contacts")
     */
    private $contacts;

    /**
     * @ORM\ManyToMany(targetEntity="Companies", inversedBy="projects")
     * @ORM\JoinTable(name="projects_companies")
     */
    private $companies;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->companies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjectName(): ?string
    {
        return $this->project_name;
    }

    public function setProjectName(string $project_name): self
    {
        $this->project_name = $project_name;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeInterface
    {
        return $this->started_at;
    }

    public function setStartedAt(\DateTimeInterface $started_at): self
    {
        $this->started_at = $started_at;

        return $this;
    }

    public function getEndedAt(): ?\DateTimeInterface
    {
        return $this->ended_at;
    }

    public function setEndedAt(?\DateTimeInterface $ended_at): self
    {
        $this->ended_at = $ended_at;

        return $this;
    }

    public function getStatut(): ?int
    {
        return $this->statut;
    }

    public function setStatut(int $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postal_code;
    }

    public function setPostalCode(int $postal_code): self
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(?int $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getImgPath(): ?string
    {
        return $this->img_path;
    }

    public function setImgPath(?string $img_path): self
    {
        $this->img_path = $img_path;

        return $this;
    }

    public function getContacts(): ?Collection
    {
        return $this->contacts;
    }

    public function getCompanies(): ?Collection
    {
        return $this->companies;
    }
}
