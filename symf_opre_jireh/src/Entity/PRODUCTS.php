<?php

namespace App\Entity;

use App\Repository\PRODUCTSRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PRODUCTSRepository::class)]
class PRODUCTS
{
    #[ORM\Id]
    #[ORM\Column(length: 255)]
    private ?string $name_product = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2, nullable: true)]
    private ?string $price = null;

    #[ORM\Column]
    private ?int $id_categoria = null;

    public function getIdProduct(): ?int
    {
        return $this->id_product;
    }

    public function setIdProduct(int $id_product): self
    {
        $this->id_product = $id_product;

        return $this;
    }

    public function getNameProduct(): ?string
    {
        return $this->name_product;
    }

    public function setNameProduct(string $name_product): self
    {
        $this->name_product = $name_product;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
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
}
