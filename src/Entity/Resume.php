<?php

namespace App\Entity;

use App\Repository\ResumeRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=ResumeRepository::class)
 */
class Resume
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
    private $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $secondName;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $patronymic;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     */
    private $graduation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $workExperience;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $wage;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="resumes")
     */
    private $hr;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthDate;

    /**
     * @ORM\OneToMany(targetEntity=HistoryVacancy::class, mappedBy="resume", orphanRemoval=true)
     * @ORM\OrderBy({"date" = "DESC"})
     */
    private $historyVacancies;

    /**
     * @ORM\OneToMany(targetEntity=ResumeToOwner::class, mappedBy="resume", orphanRemoval=true)
     */
    private $resumeToOwners;

    /**
     * @ORM\OneToMany(targetEntity=Rating::class, mappedBy="resume", orphanRemoval=true)
     */
    private $ratings;

    /**
     * @ORM\OneToMany(targetEntity=Meeting::class, mappedBy="resume", orphanRemoval=true)
     */
    private $meetings;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity=StatusHistory::class, mappedBy="resume")
     * @ORM\OrderBy({"date" = "DESC"})
     */
    private $statusHistories;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $file;

    public $filePhoto;

    /**
     * @ORM\Column(type="boolean")
     */
    private $deleted;

    public function __construct()
    {
        $this->historyVacancies = new ArrayCollection();
        $this->resumeToOwners = new ArrayCollection();
        $this->ratings = new ArrayCollection();
        $this->meetings = new ArrayCollection();
        $this->statusHistories = new ArrayCollection();
        $this->deleted = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getSecondName(): ?string
    {
        return $this->secondName;
    }

    public function setSecondName(string $secondName): self
    {
        $this->secondName = $secondName;

        return $this;
    }

    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }

    public function setPatronymic(?string $patronymic): self
    {
        $this->patronymic = $patronymic;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getGraduation(): ?string
    {
        return $this->graduation;
    }

    public function setGraduation(string $graduation): self
    {
        $this->graduation = $graduation;

        return $this;
    }

    public function getWorkExperience(): ?string
    {
        return $this->workExperience;
    }

    public function setWorkExperience(string $workExperience): self
    {
        $this->workExperience = $workExperience;

        return $this;
    }

    public function getWage(): ?string
    {
        return $this->wage;
    }

    public function setWage(?string $wage): self
    {
        $this->wage = $wage;

        return $this;
    }

    public function getHr(): ?UserInterface
    {
        return $this->hr;
    }

    public function setHr(?UserInterface $hr): self
    {
        $this->hr = $hr;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

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
            $historyVacancy->setResume($this);
        }

        return $this;
    }

    public function removeHistoryVacancy(HistoryVacancy $historyVacancy): self
    {
        if ($this->historyVacancies->removeElement($historyVacancy)) {
            // set the owning side to null (unless already changed)
            if ($historyVacancy->getResume() === $this) {
                $historyVacancy->setResume(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ResumeToOwner[]
     */
    public function getResumeToOwners(): Collection
    {
        return $this->resumeToOwners;
    }

    public function addResumeToOwner(ResumeToOwner $resumeToOwner): self
    {
        if (!$this->resumeToOwners->contains($resumeToOwner)) {
            $this->resumeToOwners[] = $resumeToOwner;
            $resumeToOwner->setResume($this);
        }

        return $this;
    }

    public function removeResumeToOwner(ResumeToOwner $resumeToOwner): self
    {
        if ($this->resumeToOwners->removeElement($resumeToOwner)) {
            // set the owning side to null (unless already changed)
            if ($resumeToOwner->getResume() === $this) {
                $resumeToOwner->setResume(null);
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
            $rating->setResume($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        if ($this->ratings->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getResume() === $this) {
                $rating->setResume(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Meeting[]
     */
    public function getMeetings(): Collection
    {
        return $this->meetings;
    }

    public function addMeeting(Meeting $meeting): self
    {
        if (!$this->meetings->contains($meeting)) {
            $this->meetings[] = $meeting;
            $meeting->setResume($this);
        }

        return $this;
    }

    public function removeMeeting(Meeting $meeting): self
    {
        if ($this->meetings->removeElement($meeting)) {
            // set the owning side to null (unless already changed)
            if ($meeting->getResume() === $this) {
                $meeting->setResume(null);
            }
        }

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullNameInitials()
    {
        $fullname = $this->getSecondName().' '.mb_substr($this->getFirstName(), 0, 1).'.';
        if ($this->getPatronymic()) {
            $fullname .= mb_substr($this->getPatronymic(), 0, 1).'.';
        }
        return $fullname;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        $fullname = $this->getSecondName().' '.$this->getFirstName();
        if ($this->getPatronymic()) {
            $fullname .= ' '.$this->getPatronymic();
        }
        return $fullname;
    }

    /**
     * @return ?Vacancy
     */
    public function getVacancy(): ?Vacancy
    {
        return $this->getHistoryVacancies()[0]->getVacancy();
    }

    /**
     * @return Collection|StatusHistory[]
     */
    public function getStatusHistories(): Collection
    {
        return $this->statusHistories;
    }

    public function addStatusHistory(StatusHistory $statusHistory): self
    {
        if (!$this->statusHistories->contains($statusHistory)) {
            $this->statusHistories[] = $statusHistory;
            $statusHistory->setResume($this);
        }

        return $this;
    }

    public function removeStatusHistory(StatusHistory $statusHistory): self
    {
        if ($this->statusHistories->removeElement($statusHistory)) {
            // set the owning side to null (unless already changed)
            if ($statusHistory->getResume() === $this) {
                $statusHistory->setResume(null);
            }
        }

        return $this;
    }

    /**
     * @return ?StatusHistory
     */
    public function getLastStatus(): ?StatusHistory
    {
        return $this->statusHistories[0];
    }


    function getAge(): string
    {
        $datetime = $this -> birthDate;
        $interval = $datetime->diff(new DateTime());
        return $interval->format("%Y");
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

}
