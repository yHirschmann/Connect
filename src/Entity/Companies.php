<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompaniesRepository")
 */
class Companies
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
    private $companie_name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_projects;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $City;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Adress;

    /**
     * @ORM\Column(type="integer")
     */
    private $postal_code;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $phone_number;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $turnover;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $social_reason;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $effective;


    /**
     * @ORM\ManyToMany(targetEntity="Project", mappedBy="companies")
     *
     */
    private $projects;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanieName(): ?string
    {
        return $this->companie_name;
    }

    public function setCompanieName(string $companie_name): self
    {
        $this->companie_name = $companie_name;

        return $this;
    }

    public function getNbProjects(): ?int
    {
        return $this->nb_projects;
    }

    public function setNbProjects(?int $nb_projects): self
    {
        $this->nb_projects = $nb_projects;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->City;
    }

    public function setCity(string $City): self
    {
        $this->City = $City;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->Adress;
    }

    public function setAdress(string $Adress): self
    {
        $this->Adress = $Adress;

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

    public function getPhoneNumber(): ?int
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?int $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getTurnover(): ?int
    {
        return $this->turnover;
    }

    public function setTurnover(?int $turnover): self
    {
        $this->turnover = $turnover;

        return $this;
    }

    public function getSocialReason(): ?string
    {
        return $this->social_reason;
    }

    public function setSocialReason(string $social_reason): self
    {
        $this->social_reason = $social_reason;

        return $this;
    }

    public function getEffective(): ?int
    {
        return $this->effective;
    }

    public function setEffective(?int $effective): self
    {
        $this->effective = $effective;

        return $this;
    }
}
