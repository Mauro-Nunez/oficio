<?php

namespace App\Entity;

use App\Repository\DelegacionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DelegacionRepository::class)]
class Delegacion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Registro>
     */
    #[ORM\ManyToMany(targetEntity: Registro::class, mappedBy: 'delegacion')]
    private Collection $registros;

    public function __construct()
    {
        $this->registros = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Registro>
     */
    public function getRegistros(): Collection
    {
        return $this->registros;
    }

    public function addRegistro(Registro $registro): static
    {
        if (!$this->registros->contains($registro)) {
            $this->registros->add($registro);
            $registro->addDelegacion($this);
        }

        return $this;
    }

    public function removeRegistro(Registro $registro): static
    {
        if ($this->registros->removeElement($registro)) {
            $registro->removeDelegacion($this);
        }

        return $this;
    }
}