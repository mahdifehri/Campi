<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PanierRepository::class)
 */
class Panier
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
    private $nbr_produit;

    /**
     * @ORM\Column(type="integer")
     */
    private $total_produit;

    /**
     * @ORM\ManyToMany(targetEntity=Produit::class, mappedBy="paniers")
     */
    private $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbrProduit(): ?int
    {
        return $this->nbr_produit;
    }

    public function setNbrProduit(int $nbr_produit): self
    {
        $this->nbr_produit = $nbr_produit;

        return $this;
    }

    public function getTotalProduit(): ?int
    {
        return $this->total_produit;
    }

    public function setTotalProduit(int $total_produit): self
    {
        $this->total_produit = $total_produit;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->addPanier($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            $produit->removePanier($this);
        }

        return $this;
    }
}