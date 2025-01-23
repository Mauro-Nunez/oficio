<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Registro $registro = null;

    #[ORM\Column]
    private ?int $calification = null;

    #[ORM\Column(length: 255)]
    private ?string $comment = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegistro(): ?Registro
    {
        return $this->registro;
    }

    public function setRegistro(?Registro $registro): static
    {
        $this->registro = $registro;

        return $this;
    }

    public function getCalification(): ?int
    {
        return $this->calification;
    }

    public function setCalification(int $calification): static
    {
        $this->calification = $calification;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}