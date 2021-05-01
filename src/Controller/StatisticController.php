<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatisticController extends AbstractController
{
    /**
     * @Route("/statistic", name="show_statistic")
     * @return Response
     */
    public function getStatistic(): Response
    {
        return $this->render(
            'statistic/show_statistic.html.twig',
            []
        );
    }
}