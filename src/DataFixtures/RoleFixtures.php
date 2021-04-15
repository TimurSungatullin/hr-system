<?php


namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $roles = array(
            'ROLE_ADMIN' => 'Админ',
            'ROLE_HR' => 'HR',
            'ROLE_CUSTOMER' => 'Заказчик',
        );

        foreach ($roles as $code => $name) {
            $role = new Role();
            $role
                ->setName($name)
                ->setCode($code)
            ;
            $manager->persist($role);
        }

        $manager->flush();
    }

}