<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;

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
     */
    private $num_cmd;

    /**
     * @ORM\Column(type="date")
     */
    private $date_cmd;

    /**
     * @ORM\Column(type="float")
     */
    private $total_cmd;

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
}
