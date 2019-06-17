<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Validator;

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

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $position;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastUpdateAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="employeeUpdated")
     */
    private $lastUpdateBy;

    /**
     * @ORM\Column(type="string", length=180, nullable=true)
     * @Validator\Regex("/(?(DEFINE)
    (?<addr_spec> (?&local_part) @ (?&domain) )
    (?<local_part> (?&dot_atom) | (?&quoted_string) | (?&obs_local_part) )
    (?<domain> (?&dot_atom) | (?&domain_literal) | (?&obs_domain) )
    (?<domain_literal> (?&CFWS)? \[ (?: (?&FWS)? (?&dtext) )* (?&FWS)? \] (?&CFWS)? )
    (?<dtext> [\x21-\x5a] | [\x5e-\x7e] | (?&obs_dtext) )
    (?<quoted_pair> \\ (?: (?&VCHAR) | (?&WSP) ) | (?&obs_qp) )
    (?<dot_atom> (?&CFWS)? (?&dot_atom_text) (?&CFWS)? )
    (?<dot_atom_text> (?&atext) (?: \. (?&atext) )* )
    (?<atext> [a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+ )
    (?<atom> (?&CFWS)? (?&atext) (?&CFWS)? )
    (?<word> (?&atom) | (?&quoted_string) )
    (?<quoted_string> (?&CFWS)? "" (?: (?&FWS)? (?&qcontent) )* (?&FWS)? "" (?&CFWS)? )
    (?<qcontent> (?&qtext) | (?&quoted_pair) )
    (?<qtext> \x21 | [\x23-\x5b] | [\x5d-\x7e] | (?&obs_qtext) )
    # comments and whitespace
    (?<FWS> (?: (?&WSP)* \r\n )? (?&WSP)+ | (?&obs_FWS) )
    (?<CFWS> (?: (?&FWS)? (?&comment) )+ (?&FWS)? | (?&FWS) )
    (?<comment> \( (?: (?&FWS)? (?&ccontent) )* (?&FWS)? \) )
    (?<ccontent> (?&ctext) | (?&quoted_pair) | (?&comment) )
    (?<ctext> [\x21-\x27] | [\x2a-\x5b] | [\x5d-\x7e] | (?&obs_ctext) )
    # obsolete tokens
    (?<obs_domain> (?&atom) (?: \. (?&atom) )* )
    (?<obs_local_part> (?&word) (?: \. (?&word) )* )
    (?<obs_dtext> (?&obs_NO_WS_CTL) | (?&quoted_pair) )
    (?<obs_qp> \\ (?: \x00 | (?&obs_NO_WS_CTL) | \n | \r ) )
    (?<obs_FWS> (?&WSP)+ (?: \r\n (?&WSP)+ )* )
    (?<obs_ctext> (?&obs_NO_WS_CTL) )
    (?<obs_qtext> (?&obs_NO_WS_CTL) )
    (?<obs_NO_WS_CTL> [\x01-\x08] | \x0b | \x0c | [\x0e-\x1f] | \x7f )
    # character class definitions
    (?<VCHAR> [\x21-\x7E] )
    (?<WSP> [ \t] )
    )/")
     */
    protected $email;


    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->added_at = DateTime::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s'));
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
        if($this->companie != $companie) {
            $this->companie = $companie;
        }
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

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): self
    {
        $this->position = $position;

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

    public function getLastUpdateBy(): ?user
    {
        return $this->lastUpdateBy;
    }

    public function setLastUpdateBy(?user $lastUpdateBy): self
    {
        $this->lastUpdateBy = $lastUpdateBy;

        return $this;
    }

}
