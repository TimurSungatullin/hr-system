<?php

namespace App\Entity;

use App\Repository\ResumeToOwnerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResumeToOwnerRepository::class)
 */
class ResumeToOwner
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Resume::class, inversedBy="resumeToOwners")
     * @ORM\JoinColumn(nullable=false)
     */
    private $resume;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="resumeToOwners")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isRead;

    public function __construct() {
        $this -> isRead = false;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getIsRead(): ?bool
    {
        return $this->isRead;
    }

    public function setIsRead(bool $isRead): self
    {
        $this->isRead = $isRead;

        return $this;
    }
}
