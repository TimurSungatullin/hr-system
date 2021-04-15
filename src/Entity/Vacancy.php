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
     * @ORM\OneToMany(targetEntity=VacancyGroup::class, mappedBy="vacancy", orphanRemoval=true)
     */
    private $vacancyGroups;

    /**
     * @ORM\OneToMany(targetEntity=VacancyHR::class, mappedBy="vacancy", orphanRemoval=true)
     */
    private $vacancyHRs;

    public function __construct()
    {
        $this->historyVacancies = new ArrayCollection();
        $this->ratings = new ArrayCollection();
        $this->vacancyGroups = new ArrayCollection();
        $this->vacancyHRs = new ArrayCollection();
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
            $vacancyGroup->setVacancy($this);
        }

        return $this;
    }

    public function removeVacancyGroup(VacancyGroup $vacancyGroup): self
    {
        if ($this->vacancyGroups->removeElement($vacancyGroup)) {
            // set the owning side to null (unless already changed)
            if ($vacancyGroup->getVacancy() === $this) {
                $vacancyGroup->setVacancy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|VacancyHR[]
     */
    public function getVacancyHRs(): Collection
    {
        return $this->vacancyHRs;
    }

    public function addVacancyHR(VacancyHR $vacancyHR): self
    {
        if (!$this->vacancyHRs->contains($vacancyHR)) {
            $this->vacancyHRs[] = $vacancyHR;
            $vacancyHR->setVacancy($this);
        }

        return $this;
    }

    public function removeVacancyHR(VacancyHR $vacancyHR): self
    {
        if ($this->vacancyHRs->removeElement($vacancyHR)) {
            // set the owning side to null (unless already changed)
            if ($vacancyHR->getVacancy() === $this) {
                $vacancyHR->setVacancy(null);
            }
        }

        return $this;
    }
}
