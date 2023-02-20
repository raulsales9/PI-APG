<?php

namespace App\Entity;

use App\Repository\CategoriasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriasRepository::class)]
class Categorias
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "Id_Categoria")]
    private ?int $idCategoria = null;

    #[ORM\Column(name: "Name_Categoria",length: 50, nullable: true)]
    private ?string $nameCategoria = null;

    #[ORM\OneToMany(mappedBy: 'Id_Categoria', targetEntity: Products::class)]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
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

    /**
     * @return Collection<int, Products>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Products $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setIdCategoria($this);
        }

        return $this;
    }

    public function removeProduct(Products $product): self
    {
        if ($this->products->removeElement($product)) {
            if ($product->getIdCategoria() === $this) {
                $product->setIdCategoria(null);
            }
        }

        return $this;
    }

}
