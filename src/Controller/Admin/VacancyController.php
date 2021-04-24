<?php

namespace App\Controller\Admin;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class VacancyController extends EasyAdminController
{
    public function createVacancyEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        $hrs = $this->getDoctrine()
            ->getRepository(User::class)
            ->findHRs();

        $formBuilder->add('hrs', EntityType::class, [
            'class' => 'App\Entity\User',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->innerJoin('u.userRoles', 'r')
                    ->andWhere('r.code = :val')
                    ->setParameter('val', Role::HR);
            },
            'by_reference' => false,
            "attr" => ["class" => "form-control select2", "data-widget" => "select2"],
            'multiple' => true,
            'required' => false,
            'label' => 'Кому доступна вакансия'
        ]);

        return $formBuilder;
    }
}