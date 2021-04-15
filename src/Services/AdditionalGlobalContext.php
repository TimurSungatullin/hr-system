<?php

namespace App\Services;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AdditionalGlobalContext
{
    private $tokenStorage;
    private $em;
    private $user;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $em)
    {
        $this->tokenStorage = $tokenStorage;
        $this->em = $em;
        if ($token = $tokenStorage -> getToken()) {
            $this->user = $token -> getUser();
        }
    }

    public function getRoles(): Collection
    {
        return $this -> user -> getUserRoles();
    }

    public function getActiveRole(): Role
    {
        $cache = new FilesystemAdapter();
        $cacheRole = $cache->getItem($this->user -> getId().'_active_role');
        if (!$cacheRole->isHit()) {
            $activeRole = $this->getRoles()[0];
        } else {
            $activeRole = $this->em
                -> getRepository(Role::class)
                -> find($cacheRole -> get())
            ;
        }

        return $activeRole;
    }

    public function getUser(): UserInterface
    {
        return $this -> user;
    }
}