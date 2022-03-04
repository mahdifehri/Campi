<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 */
class Evenement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\NotBlank(message="la date est necessaire")
     *  @Assert\GreaterThan("today")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="la destination est necessaire")
     */
    private $destination;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\PositiveOrZero
     * @Assert\Type(type="integer",message="le prix doit etre de type intier.")
     */
    private $prix;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbr_participants;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="le nombre de particapants est necessaire")
     * @Assert\Type(type="integer",message="Vous devez saisir un entier.")
     * @Assert\Positive
     */
    private $nbr_participants_max;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $etat;

    /**
     * @ORM\OneToMany(targetEntity=Participant::class, mappedBy="evenements",cascade={"persist", "remove"},orphanRemoval=true)
     */
    private $participants;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $users;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getNbrParticipants(): ?int
    {
        return $this->nbr_participants;
    }

    public function setNbrParticipants(?int $nbr_participants): self
    {
        $this->nbr_participants = $nbr_participants;

        return $this;
    }

    public function getNbrParticipantsMax(): ?int
    {
        return $this->nbr_participants_max;
    }

    public function setNbrParticipantsMax(int $nbr_participants_max): self
    {
        $this->nbr_participants_max = $nbr_participants_max;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(?int $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection|Participant[]
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participant $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
            $participant->setEvenements($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): self
    {
        if ($this->participants->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getEvenements() === $this) {
                $participant->setEvenements(null);
            }
        }

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }


}
