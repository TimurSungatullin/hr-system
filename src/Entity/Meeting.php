<?php

namespace App\Entity;

use App\Repository\MeetingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MeetingRepository::class)
 */
class Meeting
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Resume::class, inversedBy="meetings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $resume;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateMeet;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="meetings")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    public function getDateMeet(): ?\DateTimeInterface
    {
        return $this->dateMeet;
    }

    public function setDateMeet(\DateTimeInterface $dateMeet): self
    {
        $this->dateMeet = $dateMeet;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user -> addMeeting($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user -> removeMeeting($this);
        }

        return $this;
    }
}
