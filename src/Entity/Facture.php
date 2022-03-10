<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\ManyToMany(targetEntity=Commande::class, inversedBy="factures")
     */
    private $Commande;

    public function __construct()
    {
        $this->Commande = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Commande>
     */
    public function getCommande(): Collection
    {
        return $this->Commande;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->Commande->contains($commande)) {
            $this->Commande[] = $commande;
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        $this->Commande->removeElement($commande);

        return $this;
    }
}
