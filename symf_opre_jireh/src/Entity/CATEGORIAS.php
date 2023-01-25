<?php

namespace App\Entity;

use App\Repository\CATEGORIASRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CATEGORIASRepository::class)]
class CATEGORIAS
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_categoria = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $name_categoria = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCategoria(): ?int
    {
        return $this->id_categoria;
    }

    public function setIdCategoria(int $id_categoria): self
    {
        $this->id_categoria = $id_categoria;

        return $this;
    }

    public function getNameCategoria(): ?string
    {
        return $this->name_categoria;
    }

    public function setNameCategoria(?string $name_categoria): self
    {
        $this->name_categoria = $name_categoria;

        return $this;
    }
}
