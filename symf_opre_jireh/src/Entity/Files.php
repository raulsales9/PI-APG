<?php

namespace App\Entity;

use App\Repository\FilesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilesRepository::class)]
class Files
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id_file = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $up_date = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $type = null;

    #[ORM\Column]
    private ?bool $is_submitted = null;

    #[ORM\ManyToOne(inversedBy: 'userFiles')]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: "id_user")]
    private ?User $id_user = null;

    public function getIdFile(): ?int
    {
        return $this->id_file;
    }

    public function setIdFile(int $id_file): self
    {
        $this->id_file = $id_file;

        return $this;
    }
    
    public function getUpDate(): ?\DateTimeInterface
    {
        return $this->up_date;
    }

    public function setUpDate(\DateTimeInterface $up_date): self
    {
        $this->up_date = $up_date;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function isIsSubmitted(): ?bool
    {
        return $this->is_submitted;
    }

    public function setIsSubmitted(bool $is_submitted): self
    {
        $this->is_submitted = $is_submitted;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }
}
