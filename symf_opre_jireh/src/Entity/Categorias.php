<?php

namespace App\Entity;

use App\Repository\CategoriasRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriasRepository::class)]
class Categorias
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idCategoria = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nameCategoria = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCategoria(): ?int
    {
        return $this->idCategoria;
    }

    public function setIdCategoria(int $idCategoria): self
    {
        $this->idCategoria = $idCategoria;

        return $this;
    }

    public function getNameCategoria(): ?string
    {
        return $this->nameCategoria;
    }

    public function setNameCategoria(?string $nameCategoria): self
    {
        $this->nameCategoria = $nameCategoria;

        return $this;
    }
}
