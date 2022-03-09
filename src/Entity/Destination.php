<?php

namespace App\Entity;
use App\Repository\DestinationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=DestinationRepository::class)
 */
class Destination
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     */
    private $nom_dest;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     */
    private $localisation_dest;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank
     */
    private $nbr_part_dest;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank
     */
    private $event_dest;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     */
    private $image_dest;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDest(): ?string
    {
        return $this->nom_dest;
    }

    public function setNomDest(?string $nom_dest): self
    {
        $this->nom_dest = $nom_dest;

        return $this;
    }

    public function getLocalisationDest(): ?string
    {
        return $this->localisation_dest;
    }

    public function setLocalisationDest(?string $localisation_dest): self
    {
        $this->localisation_dest = $localisation_dest;

        return $this;
    }

    public function getNbrPartDest(): ?int
    {
        return $this->nbr_part_dest;
    }

    public function setNbrPartDest(?int $nbr_part_dest): self
    {
        $this->nbr_part_dest = $nbr_part_dest;

        return $this;
    }


    public function getEventDest(): ?int
    {
        return $this->event_dest;
    }

    public function setEventDest(?int $event_dest): self
    {
        $this->event_dest = $event_dest;

        return $this;
    }

    public function getImageDest(): ?string
    {
        return $this->image_dest;
    }

    public function setImageDest($image_dest): self
    {
        $this->image_dest = $image_dest;

        return $this;
    }
}
