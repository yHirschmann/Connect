<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Validator;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User extends Person implements UserInterface
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Project", mappedBy="createdBy")
     */
    private $projects;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Employee", mappedBy="added_by")
     */
    private $employees_added;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProjectFile", mappedBy="addedBy")
     */
    private $projectFiles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Project", mappedBy="lastUpdateBy")
     */
    private $projectUpdated;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Employee", mappedBy="lastUpdateBy")
     */
    private $employeeUpdated;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Companies", mappedBy="lastUpdateBy")
     */
    private $companieUpdated;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Companies", mappedBy="addedBy")
     */
    private $companies_added;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->employees_added = new ArrayCollection();
        $this->projectFiles = new ArrayCollection();
        $this->projectUpdated = new ArrayCollection();
        $this->employeeUpdated = new ArrayCollection();
        $this->companieUpdated = new ArrayCollection();
        $this->companies_added = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $project->setCreatedBy($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->contains($project)) {
            $this->projects->removeElement($project);
            // set the owning side to null (unless already changed)
            if ($project->getCreatedBy() === $this) {
                $project->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Employee[]
     */
    public function getEmployeesAdded(): Collection
    {
        return $this->employees_added;
    }

    public function addEmployeesAdded(Employee $employeesAdded): self
    {
        if (!$this->employees_added->contains($employeesAdded)) {
            $this->employees_added[] = $employeesAdded;
            $employeesAdded->setAddedBy($this);
        }

        return $this;
    }

    public function removeEmployeesAdded(Employee $employeesAdded): self
    {
        if ($this->employees_added->contains($employeesAdded)) {
            $this->employees_added->removeElement($employeesAdded);
            // set the owning side to null (unless already changed)
            if ($employeesAdded->getAddedBy() === $this) {
                $employeesAdded->setAddedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProjectFile[]
     */
    public function getProjectFiles(): Collection
    {
        return $this->projectFiles;
    }

    public function addProjectFile(ProjectFile $projectFile): self
    {
        if (!$this->projectFiles->contains($projectFile)) {
            $this->projectFiles[] = $projectFile;
            $projectFile->setAddedBy($this);
        }

        return $this;
    }

    public function removeProjectFile(ProjectFile $projectFile): self
    {
        if ($this->projectFiles->contains($projectFile)) {
            $this->projectFiles->removeElement($projectFile);
            // set the owning side to null (unless already changed)
            if ($projectFile->getAddedBy() === $this) {
                $projectFile->setAddedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProjectUpdated(): Collection
    {
        return $this->projectUpdated;
    }

    public function addProjectUpdated(Project $projectUpdated): self
    {
        if (!$this->projectUpdated->contains($projectUpdated)) {
            $this->projectUpdated[] = $projectUpdated;
            $projectUpdated->setLastUpdateBy($this);
        }

        return $this;
    }

    public function removeProjectUpdated(Project $projectUpdated): self
    {
        if ($this->projectUpdated->contains($projectUpdated)) {
            $this->projectUpdated->removeElement($projectUpdated);
            // set the owning side to null (unless already changed)
            if ($projectUpdated->getLastUpdateBy() === $this) {
                $projectUpdated->setLastUpdateBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Employee[]
     */
    public function getEmployeeUpdated(): Collection
    {
        return $this->employeeUpdated;
    }

    public function addEmployeeUpdated(Employee $employeeUpdated): self
    {
        if (!$this->employeeUpdated->contains($employeeUpdated)) {
            $this->employeeUpdated[] = $employeeUpdated;
            $employeeUpdated->setLastUpdateBy($this);
        }

        return $this;
    }

    public function removeEmployeeUpdated(Employee $employeeUpdated): self
    {
        if ($this->employeeUpdated->contains($employeeUpdated)) {
            $this->employeeUpdated->removeElement($employeeUpdated);
            // set the owning side to null (unless already changed)
            if ($employeeUpdated->getLastUpdateBy() === $this) {
                $employeeUpdated->setLastUpdateBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Companies[]
     */
    public function getCompanieUpdated(): Collection
    {
        return $this->companieUpdated;
    }

    public function addCompanieUpdated(Companies $companieUpdated): self
    {
        if (!$this->companieUpdated->contains($companieUpdated)) {
            $this->companieUpdated[] = $companieUpdated;
            $companieUpdated->setLastUpdateBy($this);
        }

        return $this;
    }

    public function removeCompanieUpdated(Companies $companieUpdated): self
    {
        if ($this->companieUpdated->contains($companieUpdated)) {
            $this->companieUpdated->removeElement($companieUpdated);
            // set the owning side to null (unless already changed)
            if ($companieUpdated->getLastUpdateBy() === $this) {
                $companieUpdated->setLastUpdateBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Companies[]
     */
    public function getCompaniesAdded(): Collection
    {
        return $this->companies_added;
    }

    public function addCompaniesAdded(Companies $companiesAdded): self
    {
        if (!$this->companies_added->contains($companiesAdded)) {
            $this->companies_added[] = $companiesAdded;
            $companiesAdded->setAddedBy($this);
        }

        return $this;
    }

    public function removeCompaniesAdded(Companies $companiesAdded): self
    {
        if ($this->companies_added->contains($companiesAdded)) {
            $this->companies_added->removeElement($companiesAdded);
            // set the owning side to null (unless already changed)
            if ($companiesAdded->getAddedBy() === $this) {
                $companiesAdded->setAddedBy(null);
            }
        }

        return $this;
    }

}
