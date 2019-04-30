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
     * @Validator\Regex("/[A-Za-z&]{1,}/")
     */
    protected $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Validator\Regex("/[A-Za-z&]{1,}/")
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
     * @Validator\Regex("/^0[1-8]([-. ]?\d{2}){4}$/")
     */
    protected $phone_number;

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
}
