<?php

namespace App\Entity;

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
     * @Validator\Regex("/[A-Za-z&]{1,}/")
     */
    private $companie_name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_projects = 0;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Validator\Regex("/^[A-Z]([- ]?[A-Za-z]){1,}/")
     */
    private $City;

    /**
     * @ORM\Column(type="string", length=255)
     * @Validator\Regex("/^\d{1,2}([. ]?[A-Za-z ]{1,}){1,}([.]?$)/")
     */
    private $Adress;

    /**
     * @ORM\Column(type="string", length=5)
     * @Validator\Length(
     *     min = 5,
     *     max = 5,
     *     minMessage = "Un numéro de téléphone doit être composé de {{ limit }} chiffres : trop court",
     *     maxMessage = "Un numéro de téléphone doit être composé de {{ limit }} chiffres : trop long"
     * )
     * @Validator\Regex("/\d{5}/")
     */
    private $postal_code;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Validator\Length(
     *     min = 10,
     *     max = 14,
     *     minMessage = "Un numéro de téléphone doit être composé de {{ limit }} chiffres : trop court",
     *     maxMessage = "Un numéro de téléphone doit être composé de {{ limit }} chiffres : trop long"
     * )
     * @Validator\Regex("/^0[1-68]([-. ]?\d{2}){4}$/")
     */
    private $phone_number;

    /**
     * @ORM\Column(type="integer", nullable=true)*
     * @Validator\Type(
     *     "integer",
     *     message="La valeur {{ value }} n'est pas un nombre)"
     * )
     */
    private $turnover;

    /**
     * @ORM\Column(type="string", length=255)
     * @Validator\Type("string")
     * @Validator\Regex("/[A-Za-z&]{1,}/")
     */
    private $social_reason;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $effective = 0;

    /**
     * @ORM\ManyToMany(targetEntity="Project", mappedBy="companies")²
     */
    private $projects;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CompanieType", inversedBy="companies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompanieEmployee", mappedBy="companie")
     */
    private $employees;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->employees = new ArrayCollection();


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

    public function setEffective(?int $effective): self
    {
        $this->effective = $effective;

        return $this;
    }

    public function setProjects(?ArrayCollection $projects): self{
        $this->projects = $projects;
        return $this;
    }

    public function getProjects(): ?ArrayCollection{
        return $this->projects;
    }

    /**
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
     * @return Collection|Person[]
     */
    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function addEmployee(CompanieEmployee $employee): self
    {
        if (!$this->employees->contains($employee)) {
            $this->employees[] = $employee;
            $employee->setCompanie($this);
        }

        return $this;
    }

    public function removeEmployee(CompanieEmployee $employee): self
    {
        if ($this->employees->contains($employee)) {
            $this->employees->removeElement($employee);
            // set the owning side to null (unless already changed)
            if ($employee->getCompanie() === $this) {
                $employee->setCompanie(null);
            }
        }

        return $this;
    }

}
