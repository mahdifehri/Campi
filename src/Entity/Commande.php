<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * Assert\Type("integer",message="Entre un nombre")
     */
    private $num_cmd;

    /**
     * @ORM\Column(type="date")
     *
     */
    private $date_cmd;

    /**
     * @ORM\Column(type="float")
     *  @Assert\NotBlank
     */
    private $total_cmd;

    /**
     * @ORM\ManyToMany(targetEntity=Facture::class, mappedBy="Commande")
     */
    private $factures;

    /**
     * @ORM\ManyToMany(targetEntity=Produit::class, inversedBy="commandes")
     */
    private $Produit;

    public function __construct()
    {
        $this->factures = new ArrayCollection();
        $this->Produit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCmd(): ?int
    {
        return $this->num_cmd;
    }

    public function setNumCmd(int $num_cmd): self
    {
        $this->num_cmd = $num_cmd;

        return $this;
    }

    public function getDateCmd(): ?\DateTimeInterface
    {
        return $this->date_cmd;
    }

    public function setDateCmd(\DateTimeInterface $date_cmd): self
    {
        $this->date_cmd = $date_cmd;

        return $this;
    }

    public function getTotalCmd(): ?float
    {
        return $this->total_cmd;
    }

    public function setTotalCmd(float $total_cmd): self
    {
        $this->total_cmd = $total_cmd;

        return $this;
    }

    /**
     * @return Collection<int, Facture>
     */
    public function getFactures(): Collection
    {
        return $this->factures;
    }

    public function addFacture(Facture $facture): self
    {
        if (!$this->factures->contains($facture)) {
            $this->factures[] = $facture;
            $facture->addCommande($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): self
    {
        if ($this->factures->removeElement($facture)) {
            $facture->removeCommande($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduit(): Collection
    {
        return $this->Produit;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->Produit->contains($produit)) {
            $this->Produit[] = $produit;
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        $this->Produit->removeElement($produit);

        return $this;
    }
}
