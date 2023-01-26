<?php

namespace App\Entity;

use App\Repository\CATEGORIASRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

#[ORM\Entity(repositoryClass: CATEGORIASRepository::class)]
class CATEGORIAS
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id_categoria = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $name_categoria = null;

    #[ORM\ManyToOne(inversedBy: 'id_product')]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'id_product')]
    private ?PRODUCTS $productList = null;

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

    public function getProductList(): ?PRODUCTS
    {
        return $this->productList;
    }

    public function setProductList(?PRODUCTS $productList): self
    {
        $this->productList = $productList;

        return $this;
    }
}
