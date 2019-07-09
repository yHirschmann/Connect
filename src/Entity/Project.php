<?php

namespace App\Entity;

use App\Repository\ProjectCompaniesRepository;
use App\Repository\ProjectFileRepository;
use App\Repository\ProjectRepository;
use App\Validator\Constraints as CustomValidator;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Validator;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use DateTimeInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 * @Vich\Uploadable
 * @CustomValidator\ConstraintProject
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
     * @Validator\LessThanOrEqual("today")
     */
    private $ended_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adress;

    /**
     * @ORM\Column(type="integer")
     */
    private $postalCode;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cost;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\employee", inversedBy="projects")
     */
    private $contacts;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="projects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * @ORM\Column(type="integer")
     * @Validator\Type(
     *     "integer",
     *     message="La valeur {{ value }} n'est pas un nombre)"
     * )
     * @Validator\Range(
     *      min = 0,
     *      max = 4,
     *      minMessage = "La phase que vous avez tenté d'entrer est incorrecte",
     *      maxMessage = "La phase que vous avez tenté d'entrer est incorrecte"
     * )
     */
    private $phase;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\projectfile", mappedBy="project")
     */
    private $files;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastUpdateAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="projectUpdated")
     */
    private $lastUpdateBy;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProjectCompanies", mappedBy="project", orphanRemoval=true)
     */
    private $companies;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->companies = new ArrayCollection();
        $this->created_at = new DateTime('now');
        $this->files = new ArrayCollection();
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

    public function getStartedAt(): ?DateTimeInterface
    {
        return $this->started_at;
    }

    public function setStartedAt(DateTimeInterface $started_at): self
    {
        $this->started_at = $started_at;

        return $this;
    }

    public function getEndedAt(): ?DateTimeInterface
    {
        return $this->ended_at;
    }

    public function setEndedAt(?DateTimeInterface $ended_at): self
    {
        $this->ended_at = $ended_at;

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
        return $this->postalCode;
    }

    public function setPostalCode(int $postalCode): self
    {
        $this->postalCode = $postalCode;

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

    /**
     * @return Collection|Employee[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Employee $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->addProject($this);
        }

        return $this;
    }

    public function removeContact(Employee $contact): self
    {
        if ($this->contacts->contains($contact)) {
            $this->contacts->removeElement($contact);
            $contact->removeProject($this);
        }

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getPhase(): ?int
    {
        return $this->phase;
    }

    public function setPhase(int $phase): self
    {
        $this->phase = $phase;

        return $this;
    }

    /**
     * @return Collection|projectfile[]
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(projectfile $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files[] = $file;
            $file->setProject($this);
        }

        return $this;
    }

    public function removeFile(projectfile $file): self
    {
        if ($this->files->contains($file)) {
            $this->files->removeElement($file);
            // set the owning side to null (unless already changed)
            if ($file->getProject() === $this) {
                $file->setProject(null);
            }
        }

        return $this;
    }

    public function getLastUpdateAt(): ?DateTimeInterface
    {
        return $this->lastUpdateAt;
    }

    public function setLastUpdateAt(?DateTimeInterface $lastUpdateAt): self
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

    /**
     * @return Collection|ProjectCompanies[]
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    public function addCompany(ProjectCompanies $company): self
    {
        if ($this->getMatchingExistingCompanies($company->getCompanies())->isEmpty()) {
            $this->companies->add($company);
            $company->setProject($this);
        }
        return $this;
    }

    public function removeCompany(ProjectCompanies $company): self
    {
        if ($this->companies->contains($company)) {
            $this->companies->removeElement($company);
            // set the owning side to null (unless already changed)
            if ($company->getProject() === $this) {
                $company->setProject(null);
            }
        }

        return $this;
    }

    public function getMatchingExistingCompanies(Companies $companies){
        $critera = ProjectCompaniesRepository::existingProjectCompanieCriteria($companies);
        return $this->companies->matching($critera);
    }

    public function getMatchingExistingFiles(UploadedFile $file){
        $critera = ProjectFileRepository::existingProjectFileCritera($file);
        return $this->files->matching($critera);
    }

    public function getMatchingExistingContacts(Employee $employee){
        $critera = ProjectRepository::existingProjectContactCriteria($employee);
        return $this->contacts->matching($critera);
    }

    public function getFullAdress(){
        return $this->adress.' '.$this->postalCode.' '.$this->getCity();
    }
}
