<?php

namespace App\Entity;

use App\Repository\TestRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TestRepository::class)
 */
class Test
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToMany(targetEntity=QuestionBlock::class)
     */
    private $questionBlocks;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->questionBlocks = new ArrayCollection();
        $this->createdAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|QuestionBlock[]
     */
    public function getQuestionBlocks(): Collection
    {
        return $this->questionBlocks;
    }

    public function addQuestionBlock(QuestionBlock $questionBlock): self
    {
        if (!$this->questionBlocks->contains($questionBlock)) {
            $this->questionBlocks[] = $questionBlock;
        }

        return $this;
    }

    public function removeQuestionBlock(QuestionBlock $questionBlock): self
    {
        $this->questionBlocks->removeElement($questionBlock);

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
