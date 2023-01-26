<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\InverseJoinColumn;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id_user = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $surname = null;

    #[ORM\Column(length: 20)]
    private ?string $phone = null;

    #[ORM\Column(length: 20)]
    private ?string $name = null;

    #[ORM\Column(length: 40)]
    private ?string $email = null;

    #[ORM\Column]
    private ?bool $is_admin = null;

    #[ORM\OneToMany(mappedBy: 'id_user', targetEntity: Files::class)]
    private Collection $userFiles;

    #[JoinTable(name: 'EVENT')]
    #[JoinColumn(name: 'id_user', referencedColumnName: 'id_user')]
    // #[InverseJoinColumn(name: 'id_event', referencedColumnName: 'id_event')]
    #[ORM\ManyToMany(targetEntity: EVENT::class)]
    private Collection $eventList;
 
    public function __construct()
    {
        $this->userFiles = new ArrayCollection();
        $this->eventList = new ArrayCollection();
    }

    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    public function setIdUser(int $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function isIsAdmin(): ?bool
    {
        return $this->is_admin;
    }

    public function setIsAdmin(bool $is_admin): self
    {
        $this->is_admin = $is_admin;

        return $this;
    }

    /**
     * @return Collection<int, Files>
     */
    public function getUserFiles(): Collection
    {
        return $this->userFiles;
    }

    public function addUserFile(Files $userFile): self
    {
        if (!$this->userFiles->contains($userFile)) {
            $this->userFiles->add($userFile);
            $userFile->setIdUser($this);
        }

        return $this;
    }

    public function removeUserFile(Files $userFile): self
    {
        if ($this->userFiles->removeElement($userFile)) {
            // set the owning side to null (unless already changed)
            if ($userFile->getIdUser() === $this) {
                $userFile->setIdUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EVENT>
     */
    public function getEventList(): Collection
    {
        return $this->eventList;
    }

    public function addEventList(EVENT $eventList): self
    {
        if (!$this->eventList->contains($eventList)) {
            $this->eventList->add($eventList);
            $eventList->addIdUser($this);
        }

        return $this;
    }

    public function removeEventList(EVENT $eventList): self
    {
        if ($this->eventList->removeElement($eventList)) {
            $eventList->removeIdUser($this);
        }

        return $this;
    }
}
