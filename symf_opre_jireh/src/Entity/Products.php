<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductsRepository::class)]
class Products
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idProduct = null;

    #[ORM\Column(length: 50)]
    private ?string $nameProduct = null;

    #[ORM\Column(nullable: true)]
    private ?int $price = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: "Id_Categoria", name: "Id_Categoria")]
    private ?Categorias $IdCategoria = null;

  
    public function getIdProduct(): ?int
    {
        return $this->idProduct;
    }

    public function setIdProduct(int $idProduct): self
    {
        $this->idProduct = $idProduct;

        return $this;
    }


    public function getNameProduct(): ?string
    {
        return $this->nameProduct;
    }

    public function setNameProduct(string $nameProduct): self
    {
        $this->nameProduct = $nameProduct;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getIdCategoria(): ?Categorias
    {
        return $this->IdCategoria;
    }

    public function setIdCategoria(?Categorias $IdCategoria): self
    {
        $this->IdCategoria = $IdCategoria;

        return $this;
    }

  
}
