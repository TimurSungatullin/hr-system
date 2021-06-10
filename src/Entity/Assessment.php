<?php

namespace App\Entity;

use App\Repository\AssessmentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AssessmentRepository::class)
 */
class Assessment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $point;

    /**
     * @ORM\ManyToOne(targetEntity=Skill::class, inversedBy="assessments")
     */
    private $skills;

    /**
     * @ORM\ManyToOne(targetEntity=Resume::class, inversedBy="assessments")
     */
    private $resumes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoint(): ?int
    {
        return $this->point;
    }

    public function setPoint(?int $point): self
    {
        $this->point = $point;

        return $this;
    }

    public function getSkills(): ?Skill
    {
        return $this->skills;
    }

    public function setSkills(?Skill $skills): self
    {
        $this->skills = $skills;

        return $this;
    }

    public function getResumes(): ?Resume
    {
        return $this->resumes;
    }

    public function setResumes(?Resume $resumes): self
    {
        $this->resumes = $resumes;

        return $this;
    }
}
