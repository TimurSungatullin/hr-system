<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GroupRepository::class)
 * @ORM\Table(name="`group`")
 */
class Group
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Vacancy::class, mappedBy="groups")
     */
    private $vacancies;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="groups")
     * @ORM\JoinTable(name="group_hr")
     */
    private $hrs;

    public function __construct()
    {
        $this->vacancies = new ArrayCollection();
        $this->hrs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Vacancy[]
     */
    public function getVacancies(): Collection
    {
        return $this->vacancies;
    }

    public function addVacancy(Vacancy $vacancy): self
    {
        if (!$this->vacancies->contains($vacancy)) {
            $this->vacancies[] = $vacancy;
            $vacancy->addGroup($this);
        }

        return $this;
    }

    public function removeVacancy(Vacancy $vacancy): self
    {
        if ($this->vacancies->removeElement($vacancy)) {
            $vacancy->removeGroup($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return Collection|User[]
     */
    public function getHrs(): Collection
    {
        return $this->hrs;
    }

    public function addHr(User $hr): self
    {
        if (!$this->hrs->contains($hr)) {
            $this->hrs[] = $hr;
            $hr->addGroup($this);
        }

        return $this;
    }

    public function removeHr(User $hr): self
    {
        if ($this->hrs->removeElement($hr)) {
            $hr->removeGroup($this);
        }

        return $this;
    }
}
