<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255 , unique=true)
     */
    private $nom;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @Assert\NotBlank
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 8,
     *      max = 20,
     */
    private $motpasse;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      max = 8,
     */
    private $numero_telephone;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=1)
     * @Assert\EqualTo(
     *     value = "a"
     * )
     * @Assert\Length(max=1)
     */
    private $role;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $photoUser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function getMotpasse(): ?string
    {
        return $this->motpasse;
    }

    public function setMotpasse(string $motpasse): self
    {
        $this->motpasse = $motpasse;

        return $this;
    }

    public function getNumeroTelephone(): ?string
    {
        return $this->numero_telephone;
    }

    public function setNumeroTelephone(string $numero_telephone): self
    {
        $this->numero_telephone = $numero_telephone;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getPhotoUser(): ?string
    {
        return $this->photoUser;
    }

    public function setPhotoUser($photoUser): self
    {
        $this->photoUser = $photoUser;

        return $this;
    }
}
