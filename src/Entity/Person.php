<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Validator;

/**
 * @ORM\MappedSuperclass()
 */
abstract class Person
{

    /**
     * @ORM\Column(type="string", length=255)
     * @Validator\Regex("/[A-Za-zÀ-ÿ&]{1,}/")
     */
    protected $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Validator\Regex("/[A-Za-zÀ-ÿ&]{1,}/")
     */
    protected $last_name;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Validator\Length(
     *     min = 10,
     *     max = 14,
     *     minMessage = "Un numéro de téléphone doit être composé de {{ limit }} chiffres : trop court",
     *     maxMessage = "Un numéro de téléphone doit être composé de {{ limit }} chiffres : trop long"
     * )
     * @Validator\Regex("/^0[1-9]([-. ]?\d{2}){4}$/")
     */
    protected $phone_number;

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUserFullName(): ?string {
        return $this->getFirstName().' '.$this->getLastName();
    }
}
