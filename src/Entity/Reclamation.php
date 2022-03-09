<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReclamationRepository::class)
 */
class Reclamation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id_rec;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_rec;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description_rec;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat_rec;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $flag;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity=Destination::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $destination;

    public function getIdRec(): ?int
    {
        return $this->id_rec;
    }

    public function getTypeRec(): ?string
    {
        return $this->type_rec;
    }

    public function setTypeRec(string $type_rec): self
    {
        $this->type_rec = $type_rec;

        return $this;
    }

    public function getDescriptionRec(): ?string
    {
        return $this->description_rec;
    }

    public function setDescriptionRec(string $description_rec): self
    {
        $this->description_rec = $description_rec;

        return $this;
    }

    public function getEtatRec(): ?string
    {
        return $this->etat_rec;
    }

    public function setEtatRec(string $etat_rec): self
    {
        $this->etat_rec = $etat_rec;

        return $this;
    }

    public function getFlag(): ?int
    {
        return $this->flag;
    }

    public function setFlag(?int $flag): self
    {
        $this->flag = $flag;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile($file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getDestination(): ?Destination
    {
        return $this->destination;
    }

    public function setDestination(?Destination $destination): self
    {
        $this->destination = $destination;

        return $this;
    }
}
