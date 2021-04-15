<?php

namespace App\Controller;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


final class AdminController extends EasyAdminController
{

    private $encoder;

    private function setUserPlainPassword(User $user): void
    {
        if ($user->getPlainPassword()) {
            $user->setPassword($this->encoder->encodePassword($user, $user->getPlainPassword()));
        }
    }

    /**
     * @required
     */
    public function setEncoder(UserPasswordEncoderInterface $encoder): void
    {
        $this->encoder = $encoder;
    }

    public function persistUserEntity(User $user): void
    {
        $this->setUserPlainPassword($user);

        $this->persistEntity($user);

        parent::persistEntity($user);
    }

    public function updateUserEntity(User $user): void
    {
        $this->setUserPlainPassword($user);

        $this->updateEntity($user);

        parent::updateEntity($user);
    }
}