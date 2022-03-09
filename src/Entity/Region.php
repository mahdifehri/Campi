<?php

namespace App\Entity;

use App\Repository\RegionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RegionRepository::class)
 */
class Region
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom_reg;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $localisation_reg;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbr_participants_reg;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbr_event_reg;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomReg(): ?string
    {
        return $this->nom_reg;
    }

    public function setNomReg(?string $nom_reg): self
    {
        $this->nom_reg = $nom_reg;

        return $this;
    }

    public function getLocalisationReg(): ?string
    {
        return $this->localisation_reg;
    }

    public function setLocalisationReg(?string $localisation_reg): self
    {
        $this->localisation_reg = $localisation_reg;

        return $this;
    }

    public function getNbrParticipantsReg(): ?int
    {
        return $this->nbr_participants_reg;
    }

    public function setNbrParticipantsReg(?int $nbr_participants_reg): self
    {
        $this->nbr_participants_reg = $nbr_participants_reg;

        return $this;
    }

    public function getNbrEventReg(): ?int
    {
        return $this->nbr_event_reg;
    }

    public function setNbrEventReg(?int $nbr_event_reg): self
    {
        $this->nbr_event_reg = $nbr_event_reg;

        return $this;
    }
}
