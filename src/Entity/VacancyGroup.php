<?php

namespace App\Entity;

use App\Repository\VacancyGroupRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VacancyGroupRepository::class)
 */
class VacancyGroup
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Vacancy::class, inversedBy="vacancyGroups")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vacancy;

    /**
     * @ORM\ManyToOne(targetEntity=Group::class, inversedBy="vacancyGroups")
     * @ORM\JoinColumn(nullable=false)
     */
    private $group;

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

    public function getGroup(): ?Group
    {
        return $this->group;
    }

    public function setGroup(?Group $group): self
    {
        $this->group = $group;

        return $this;
    }
}
