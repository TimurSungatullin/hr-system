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
     * @ORM\OneToMany(targetEntity=VacancyGroup::class, mappedBy="groupId", orphanRemoval=true)
     */
    private $vacancyGroups;

    public function __construct()
    {
        $this->vacancyGroups = new ArrayCollection();
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
     * @return Collection|VacancyGroup[]
     */
    public function getVacancyGroups(): Collection
    {
        return $this->vacancyGroups;
    }

    public function addVacancyGroup(VacancyGroup $vacancyGroup): self
    {
        if (!$this->vacancyGroups->contains($vacancyGroup)) {
            $this->vacancyGroups[] = $vacancyGroup;
            $vacancyGroup->setGroup($this);
        }

        return $this;
    }

    public function removeVacancyGroup(VacancyGroup $vacancyGroup): self
    {
        if ($this->vacancyGroups->removeElement($vacancyGroup)) {
            // set the owning side to null (unless already changed)
            if ($vacancyGroup->getGroup() === $this) {
                $vacancyGroup->setGroup(null);
            }
        }

        return $this;
    }
}
