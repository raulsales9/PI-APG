<?php

namespace App\Entity;

use App\Repository\PRODUCTSRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PRODUCTSRepository::class)]
class PRODUCTS
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id_product = null;

    #[ORM\Column(length: 255)]
    private ?string $name_product = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2, nullable: true)]
    private ?string $price = null;

    #[ORM\OneToMany(mappedBy: 'productList', targetEntity: CATEGORIAS::class)]
    private Collection $id_categoria;

    public function __construct()
    {
        $this->id_categoria = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, CATEGORIAS>
     */
    public function getIdCategoria(): Collection
    {
        return $this->id_categoria;
    }

    public function addIdCategorium(CATEGORIAS $idCategorium): self
    {
        if (!$this->id_categoria->contains($idCategorium)) {
            $this->id_categoria->add($idCategorium);
            $idCategorium->setProductList($this);
        }

        return $this;
    }

    public function removeIdCategorium(CATEGORIAS $idCategorium): self
    {
        if ($this->id_categoria->removeElement($idCategorium)) {
            // set the owning side to null (unless already changed)
            if ($idCategorium->getProductList() === $this) {
                $idCategorium->setProductList(null);
            }
        }

        return $this;
    }
}
