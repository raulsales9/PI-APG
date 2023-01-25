<?php

namespace App\Entity;

use App\Repository\NoticiasRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NoticiasRepository::class)]
class Noticias
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id_noticia = null;

    #[ORM\Column(length: 40)]
    private ?string $titulo = null;

    #[ORM\Column(length: 30)]
    private ?string $imagen = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $texto = null;

    public function getIdNoticia(): ?int
    {
        return $this->id_noticia;
    }

    public function setIdNoticia(int $id_noticia): self
    {
        $this->id_noticia = $id_noticia;

        return $this;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getTexto(): ?string
    {
        return $this->texto;
    }

    public function setTexto(string $texto): self
    {
        $this->texto = $texto;

        return $this;
    }
}
