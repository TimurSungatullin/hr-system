<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class StatusFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $statusNames = array(
            1 => 'Резюме',
            2 => 'Телефонное интервью',
            3 => 'Встреча (первичная)',
            4 => 'Встреча (итоговая)',
            5 => 'Приглашение на работу',
            6 => 'Отказ',
        );

        foreach ($statusNames as $name) {
            $status = new Status();
            $status->setName($name);
            $manager->persist($status);
        }

        $manager->flush();
    }
}