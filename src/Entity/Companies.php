<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Validator;

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
     * @Validator\Regex("/[\dA-Za-zÀ-ÿ&]{1,}/")
     */
    private $companie_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Validator\Regex("/^[A-Z]([- ]?[A-Za-zÀ-ÿ]){1,}/")
     */
    private $City;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Validator\Regex("/^$|^\d{1,3}([\.\,\ \'\]?[A-Za-zÀ-ÿ ]{1,}){1,}([.]?$)/")
     */
    private $Adress;

    /**
     * @ORM\Column(type="string", length=9)
     * @Validator\Length(
     *     min = 4,
     *     max = 9,
     *     minMessage = "Un numéro de téléphone doit être composé de {{ limit }} chiffres : trop court",
     *     maxMessage = "Un numéro de téléphone doit être composé de {{ limit }} chiffres : trop long"
     * )
     * @Validator\Regex("/(\d{4,5})|(\d{4}\-\d{4})/")
     */
    private $postal_code;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Validator\Length(
     *     min = 10,
     *     max = 14,
     *     minMessage = "Un numéro de téléphone doit être composé de {{ limit }} caractères : trop court",
     *     maxMessage = "Un numéro de téléphone doit être composé de {{ limit }} caractères : trop long"
     * )
     * @Validator\Regex("/^0[1-9]([-. ]?\d{2}){4}$/")
     */
    private $phone_number;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Validator\Type(
     *     "integer",
     *     message="La valeur {{ value }} n'est pas un nombre)"
     * )
     *
     */
    private $turnover;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Validator\Type("string")
     * @Validator\Regex("/[A-Za-zÀ-ÿ&]{1,}/")
     */
    private $social_reason;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $effective = 0;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CompanieType", inversedBy="companies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * Collection of Employees
     * @ORM\OneToMany(targetEntity="App\Entity\Employee", mappedBy="companie")
     */
    private $employees;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastUpdateAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="companieUpdated")
     */
    private $lastUpdateBy;

    /**
     * Collection of Project
     * @ORM\OneToMany(targetEntity="App\Entity\projectcompanies", mappedBy="companies", orphanRemoval=true)
     */
    private $project;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="companies_added")
     * @ORM\JoinColumn(nullable=false)
     */
    private $addedBy;

    /**
     * @ORM\Column(type="datetime")
     */
    private $added_at;

    public function __construct()
    {
        $this->employees = new ArrayCollection();
        $this->project = new ArrayCollection();
    }

    public function __toString()
    {
        return '';
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

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $postal_code): self
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number): self
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

    /**
     * Get the phone number from the $companie
     * Format it, delete spaces, dots and dash
     * Retrun the companie
     *
     * @param Companies $companie
     * @return Companies
     */
    public function formatCompaniePhoneNumber(Companies $companie){
        $phoneNumber = $companie->getPhoneNumber();
        $chars = array(' ','.','-');
        $companie->setPhoneNumber(str_replace($chars, '', $phoneNumber));
        return $companie;
    }

    /**
     * Get the social reason from the $companie
     * Set the first character of the string to uppercase
     * Retrun the companie
     *
     * @param Companies $companie
     * @return Companies
     */
    public function formatCompanieSocialReason(Companies $companie){
        $socialReason = $companie->getSocialReason();
        $companie->setSocialReason(ucfirst($socialReason));
        return $companie;
    }

    public function getType(): ?CompanieType
    {
        return $this->type;
    }

    public function setType(?CompanieType $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return Collection|Employee[]
     */
    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function addEmployee(Employee $employee): self
    {
        if (!$this->employees->contains($employee)) {
            $this->employees->add($employee);
            $this->effective += 1;
            $employee->setCompanie($this);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): self
    {
        if ($this->employees->contains($employee)) {
            $this->employees->removeElement($employee);
            $this->effective -= 1;
            // set the owning side to null (unless already changed)
            if ($employee->getCompanie() === $this) {
                $employee->setCompanie(null);
            }
        }
        return $this;
    }

    public function getLastUpdateAt(): ?DateTimeInterface
    {
        return $this->lastUpdateAt;
    }

    public function setLastUpdateAt(DateTimeInterface $lastUpdateAt): self
    {
        $this->lastUpdateAt = $lastUpdateAt;

        return $this;
    }

    public function getLastUpdateBy(): ?User
    {
        return $this->lastUpdateBy;
    }

    public function setLastUpdateBy(?User $lastUpdateBy): self
    {
        $this->lastUpdateBy = $lastUpdateBy;

        return $this;
    }

    /**
     * @return Collection|projectcompanies[]
     */
    public function getProject(): Collection
    {
        return $this->project;
    }

    public function addProject(projectcompanies $project): self
    {
        if (!$this->project->contains($project)) {
            $this->project[] = $project;
            $project->setCompanies($this);
        }

        return $this;
    }

    public function removeProject(projectcompanies $project): self
    {
        if ($this->project->contains($project)) {
            $this->project->removeElement($project);
            // set the owning side to null (unless already changed)
            if ($project->getCompanies() === $this) {
                $project->setCompanies(null);
            }
        }

        return $this;
    }

    public function getAddedBy(): ?User
    {
        return $this->addedBy;
    }

    public function setAddedBy(?User $addedBy): self
    {
        $this->addedBy = $addedBy;

        return $this;
    }

    public function getAddedAt(): ?DateTimeInterface
    {
        return $this->added_at;
    }

    public function setAddedAt(DateTimeInterface $added_at): self
    {
        $this->added_at = $added_at;

        return $this;
    }

    public function getFullAdress(){
        return $this->getAdress().' '.$this->getPostalCode().' '.$this->getCity();
    }
}
