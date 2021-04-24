<?php

namespace App\Entity;

use App\Repository\VacancyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VacancyRepository::class)
 */
class Vacancy
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
     * @ORM\OneToMany(targetEntity=HistoryVacancy::class, mappedBy="vacancy", orphanRemoval=true)
     */
    private $historyVacancies;

    /**
     * @ORM\OneToMany(targetEntity=Rating::class, mappedBy="vacancy")
     */
    private $ratings;

    /**
     * @ORM\ManyToMany(targetEntity=Group::class, inversedBy="vacancies")
     */
    private $groups;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="vacancies")
     * @ORM\JoinTable(name="vacancy_hr")
     */
    private $hrs;

    public function __construct()
    {
        $this->historyVacancies = new ArrayCollection();
        $this->ratings = new ArrayCollection();
        $this->hrs = new ArrayCollection();
        $this->groups = new ArrayCollection();
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
     * @return Collection|HistoryVacancy[]
     */
    public function getHistoryVacancies(): Collection
    {
        return $this->historyVacancies;
    }

    public function addHistoryVacancy(HistoryVacancy $historyVacancy): self
    {
        if (!$this->historyVacancies->contains($historyVacancy)) {
            $this->historyVacancies[] = $historyVacancy;
            $historyVacancy->setVacancy($this);
        }

        return $this;
    }

    public function removeHistoryVacancy(HistoryVacancy $historyVacancy): self
    {
        if ($this->historyVacancies->removeElement($historyVacancy)) {
            // set the owning side to null (unless already changed)
            if ($historyVacancy->getVacancy() === $this) {
                $historyVacancy->setVacancy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Rating[]
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(Rating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setVacancy($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        if ($this->ratings->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getVacancy() === $this) {
                $rating->setVacancy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(Group $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
            $group->addVacancy($this);
        }

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        if ($this->groups->removeElement($group)) {
            $group->removeVacancy($this);
        };

        return $this;
    }


    /**
     * @return Collection|User[]
     */
    public function getHrs(): Collection
    {
        return $this->hrs;
    }

    public function addHR(User $hr): self
    {
        if (!$this->hrs->contains($hr)) {
            $this->hrs[] = $hr;
            $hr->addVacancy($this);
        }

        return $this;
    }

    public function removeHR(User $hr): self
    {
        if ($this->hrs->removeElement($hr)) {
            $hr->removeVacancy($this);
        };

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
