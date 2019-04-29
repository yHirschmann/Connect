<?php

namespace App\Entity;

use DateTime;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

use App\Validator\Constraints as CustomValidator;
use Symfony\Component\Validator\Constraints as Validator;



/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 * @Vich\Uploadable
 * @CustomValidator\CronstraintDateLessThanAnother()
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
     * @Vich\UploadableField(mapping="project_images", fileNameProperty="imageName", size="imageSize", mimeType="imageMimeType", originalName="imageOriginalName")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $imageSize;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageMineType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageOriginalName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\companies", inversedBy="projects")
     */
    private $companies;

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

    public function __construct()
    {
        $this->image = new EmbeddedFile();
        $this->contacts = new ArrayCollection();
        $this->companies = new ArrayCollection();
        $this->updatedAt =  new DateTime('now');
        $this->created_at = new DateTime('now');
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
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile $imageFile
     */
    public function setImageFile(?File $imageFile = null)
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImage(EmbeddedFile $image)
    {
        $this->image = $image;
    }

    public function getImage(): ?EmbeddedFile
    {
        return $this->image;
    }

    /**
     * @return Collection|Companies[]
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    public function addCompany(Companies $company): self
    {
        if (!$this->companies->contains($company)) {
            $this->companies->add($company);
            $company->addProject($this);
        }

        return $this;
    }

    public function removeCompany(Companies $company): self
    {
        if ($this->companies->contains($company)) {
            $this->companies->removeElement($company);
        }

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
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

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function setImageSize(?int $imageSize): self
    {
        $this->imageSize = $imageSize;

        return $this;
    }

    public function getImageMineType(): ?string
    {
        return $this->imageMineType;
    }

    public function setImageMineType(?string $imageMineType): self
    {
        $this->imageMineType = $imageMineType;

        return $this;
    }

    public function getImageOriginalName(): ?string
    {
        return $this->imageOriginalName;
    }

    public function setImageOriginalName(?string $imageOriginalName): self
    {
        $this->imageOriginalName = $imageOriginalName;

        return $this;
    }

}
