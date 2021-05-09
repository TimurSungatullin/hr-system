<?php

namespace App\Entity;

use App\Repository\RatingRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=RatingRepository::class)
 */
class Rating
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Resume::class, inversedBy="ratings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $resume;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ratings")
     */
    private $user;

    /**
     * @ORM\Column(type="smallint")
     * @Groups({"add_comment"})
     */
    private $score;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"add_comment"})
     */
    private $comment;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"add_comment"})
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Vacancy::class, inversedBy="ratings")
     */
    private $vacancy;

    /**
     * @Groups({"add_comment"})
     */
    private $statusName;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class, inversedBy="ratings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $role;

    /**
     * @Groups({"add_comment"})
     */
    private $roleName;

    public function __construct() {
        $this->date = new DateTime();
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

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

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

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

    public function getStatusName(): string
    {
        return $this->status->getName();
    }

    public function getRoleName(): string
    {
        return $this->role->getName();
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

}
