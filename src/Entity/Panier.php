<?php

namespace App\Entity;

use App\Repository\PanierRepository;
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
}
