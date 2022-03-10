<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
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
    private $id_post;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="le contenu est necessaire")
     * @Assert\Length(
     *      min = 1,
     *      minMessage = "Your comment must be at least {{ min }} characters long")
     */
    private $contenu;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_user;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $posts;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPost(): ?int
    {
        return $this->id_post;
    }

    public function setIdPost(int $id_post): self
    {
        $this->id_post = $id_post;

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

    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    public function setIdUser(int $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getPosts(): ?Post
    {
        return $this->posts;
    }

    public function setPosts(?Post $posts): self
    {
        $this->posts = $posts;

        return $this;
    }

}
