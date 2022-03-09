<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FactureRepository::class)
 */
class Facture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numFact;

    /**
     * @ORM\Column(type="float")
     */
    private $totalFact;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFact;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumFact(): ?int
    {
        return $this->numFact;
    }

    public function setNumFact(int $numFact): self
    {
        $this->numFact = $numFact;

        return $this;
    }

    public function getTotalFact(): ?float
    {
        return $this->totalFact;
    }

    public function setTotalFact(float $totalFact): self
    {
        $this->totalFact = $totalFact;

        return $this;
    }

    public function getDateFact(): ?\DateTimeInterface
    {
        return $this->dateFact;
    }

    public function setDateFact(\DateTimeInterface $dateFact): self
    {
        $this->dateFact = $dateFact;

        return $this;
    }
}
