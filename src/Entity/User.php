<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Table(name="`user`")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("username")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue()
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
     * @ORM\Column(type="string", length=100)
     */
    private $patronymic;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     *
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=5, max=255)
     */
    private $plainPassword;

    /**
     * @ORM\OneToMany(targetEntity=Resume::class, mappedBy="hr")
     */
    private $resumes;

    /**
     * @ORM\OneToMany(targetEntity=ResumeToOwner::class, mappedBy="owner", orphanRemoval=true)
     */
    private $resumeToOwners;

    /**
     * @ORM\OneToMany(targetEntity=Rating::class, mappedBy="user")
     */
    private $ratings;

    /**
     * @ORM\ManyToMany(targetEntity=Role::class, mappedBy="users")
     */
    private $userRoles;

    /**
     * @ORM\ManyToMany(targetEntity=Meeting::class, mappedBy="users")
     */
    private $meetings;

    /**
     * @ORM\ManyToMany(targetEntity=Vacancy::class, mappedBy="hrs")
     * @ORM\JoinTable(name="vacancy_hr")
     */
    private $vacancies;

    private $fullName;

    /**
     * @ORM\ManyToMany(targetEntity=Group::class, mappedBy="hrs")
     */
    private $groups;

    public function __construct()
    {
        $this->resumes = new ArrayCollection();
        $this->resumeToOwners = new ArrayCollection();
        $this->ratings = new ArrayCollection();
        $this->userRoles = new ArrayCollection();
        $this->meetings = new ArrayCollection();
        $this->groups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }


    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return array() The user roles
     */
    public function getRoles()
    {
        $arr = array();
        foreach ($this->userRoles as $role) {
            $arr[] = $role->getCode();
        }
        return $arr;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

//    public function getRole(): ?string
//    {
//        return $this->role;
//    }
//
//    public function setRole(string $role): self
//    {
//        $this->role = $role;
//
//        return $this;
//    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return Collection|Resume[]
     */
    public function getResumes(): Collection
    {
        return $this->resumes;
    }

    public function getActiveResumes(int $status = null, int $vacancy = null): array
    {
        $resumes = array_filter($this->resumes -> toArray(), function ($resume) {
            return !$resume -> getDeleted();
        });

        if ($status) {
            $resumes = array_filter($resumes, function ($resume) use ($status) {
                return $resume->getLastStatus()->getStatus()->getId() == $status;
            });
        }

        if ($vacancy) {
            $resumes = array_filter($resumes, function ($resume) use ($vacancy) {
                return $resume->getVacancy()->getId() == $vacancy;
            });
        }
        return $resumes;
    }

    public function addResume(Resume $resume): self
    {
        if (!$this->resumes->contains($resume)) {
            $this->resumes[] = $resume;
            $resume->setHr($this);
        }

        return $this;
    }

    public function removeResume(Resume $resume): self
    {
        if ($this->resumes->removeElement($resume)) {
            // set the owning side to null (unless already changed)
            if ($resume->getHr() === $this) {
                $resume->setHr(null);
            }
        }

        return $this;
    }

    /**
     * @param int|null $vacancy
     * @param int|null $status
     * @return Collection
     */
    public function getResumeToOwners(int $status = null, int $vacancy = null): array
    {
        $resumes = $this->resumeToOwners -> toArray();
        if ($status) {
            $resumes = array_filter(
                $resumes,
                function ($resume) use ($status) {
                    return $resume
                            ->getResume()
                            ->getLastStatus()
                            ->getStatus()
                            ->getId() == $status;
            });
        }

        if ($vacancy) {
            $resumes = array_filter(
                $resumes,
                function (ResumeToOwner $resume) use ($vacancy) {
                    return $resume
                            ->getResume()
                            ->getVacancy()
                            ->getId() == $vacancy;
            });
        }
        return $resumes;
    }

    public function addResumeToOwner(ResumeToOwner $resumeToOwner): self
    {
        if (!$this->resumeToOwners->contains($resumeToOwner)) {
            $this->resumeToOwners[] = $resumeToOwner;
            $resumeToOwner->setOwner($this);
        }

        return $this;
    }

    public function removeResumeToOwner(ResumeToOwner $resumeToOwner): self
    {
        if ($this->resumeToOwners->removeElement($resumeToOwner)) {
            // set the owning side to null (unless already changed)
            if ($resumeToOwner->getOwner() === $this) {
                $resumeToOwner->setOwner(null);
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
            $rating->setUser($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        if ($this->ratings->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getUser() === $this) {
                $rating->setUser(null);
            }
        }

        return $this;
    }

    public function getUserRoles(): Collection {
        return $this->userRoles;
    }

    public function addUserRole(Role $role): self
    {
        if (!$this->userRoles->contains($role)) {
            $this->userRoles[] = $role;
            $role->addUser($this);
        }

        return $this;
    }

    public function removeUserRole(Role $role): self
    {
        if ($this->userRoles->removeElement($role)) {
            $role->removeUser($this);
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
            $meeting->addUser($this);
        }

        return $this;
    }

    public function removeMeeting(Meeting $meeting): self
    {
        if ($this->meetings->removeElement($meeting)) {
            $meeting->removeUser($this);
        }

        return $this;
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


    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        $fullName = $this->getSecondName().' '.$this->getFirstName();
        if ($this->getPatronymic()) {
            $fullName .= ' '.$this->getPatronymic();
        }
        return $fullName;
    }

    /**
     * @param mixed $fullName
     */
    public function setFullName($fullName): void
    {
        $this->fullName = $fullName;
    }

    public function getInitials(): string
    {
        $initials = $this->getSecondName().' '.mb_substr($this->getFirstName(), 0, 1).'.';
        if ($this->getPatronymic()) {
            $initials .= mb_substr($this->getPatronymic(), 0, 1).'.';
        }
        return $initials;
    }

    /**
     * @param $vacancy Vacancy
     * @return bool
     */
    public function hasAccessVacancy(Vacancy $vacancy): bool
    {
        return $this -> getAllVacancy() -> contains($vacancy);
    }

    /**
     * @return Collection|Vacancy[]
     */
    public function getVacancies(): Collection
    {
        return $this->vacancies;
    }

    public function addVacancy(Vacancy $vacancy): self
    {
        if (!$this->vacancies->contains($vacancy)) {
            $this->vacancies[] = $vacancy;
            $vacancy->addHR($this);
        }

        return $this;
    }

    public function removeVacancy(Vacancy $vacancy): self
    {
        if ($this->vacancies->removeElement($vacancy)) {
            $vacancy->removeHR($this);
        };

        return $this;
    }

    public function __toString(): string
    {
        return $this->getFullName();
    }

    /**
     * @return Collection|Group[]
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(Group $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
            $group->addHr($this);
        }

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        if ($this->groups->removeElement($group)) {
            $group->removeHr($this);
        }

        return $this;
    }

    public function getAllVacancy(): Collection
    {
        $allVacancy = $this->getVacancies();
        foreach ($this -> getGroups() as $group) {
            foreach ($group -> getVacancies() as $vacancy) {
                if (!$allVacancy->contains($vacancy)) {
                    $allVacancy -> add($vacancy);
                }
            }
        }

        return $allVacancy;
    }
}
