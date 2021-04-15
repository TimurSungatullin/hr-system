<?php

namespace App\Entity;

use App\Repository\HistoryVacancyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HistoryVacancyRepository::class)
 */
class HistoryVacancy
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Vacancy::class, inversedBy="historyVacancies", cascade={"remove"})
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $vacancy;

    /**
     * @ORM\ManyToOne(targetEntity=Resume::class, inversedBy="historyVacancies", cascade={"remove"})
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $resume;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getResume(): ?Resume
    {
        return $this->resume;
    }

    public function setResume(?Resume $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
