<?php

namespace App\Entity;

use App\Repository\VacancyHRRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VacancyHRRepository::class)
 */
class VacancyHR
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="vacancyHRs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $hr;

    /**
     * @ORM\ManyToOne(targetEntity=Vacancy::class, inversedBy="vacancyHRs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vacancy;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHr(): ?User
    {
        return $this->hr;
    }

    public function setHr(?User $hr): self
    {
        $this->hr = $hr;

        return $this;
    }

    public function getVacancy(): ?Vacancy
    {
        return $this->vacancy;
    }

    public function setVacancy(?Vacancy $vacancy): self
    {
        $this->vacancy = $vacancy;

        return $this;
    }
}
