<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Expr\Array_;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
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
    private $id_user;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="le contenu est necessaire")
     * @Assert\Length(
     *      min = 1,
     *      minMessage = "Your post must be at least {{ limit }} characters long",
     * )
     */
    private $contenu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbr_reaction;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbr_commentaire;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $etat;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="le titre est necessaire")
     */
    private $titre;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="posts", orphanRemoval=true)
     */
    private $commentaires;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    public function setIdUser(int $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

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

    public function getNbrReaction(): ?int
    {
        return $this->nbr_reaction;
    }

    public function setNbrReaction(?int $nbr_reaction): self
    {
        $this->nbr_reaction = $nbr_reaction;

        return $this;
    }

    public function getNbrCommentaire(): ?int
    {
        return $this->nbr_commentaire;
    }

    public function setNbrCommentaire(?int $nbr_commentaire): self
    {
        $this->nbr_commentaire = $nbr_commentaire;

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


    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setPosts($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getPosts() === $this) {
                $commentaire->setPosts(null);
            }
        }

        return $this;
    }


}
