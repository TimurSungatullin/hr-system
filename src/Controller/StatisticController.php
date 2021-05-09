<?php


namespace App\Controller;


use App\Entity\Resume;
use App\Entity\Role;
use App\Entity\Status;
use App\Entity\Vacancy;
use App\Services\AdditionalGlobalContext;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatisticController extends AbstractController
{

    public function getCountResumes($resumes, $role) {
        $count = count(
            array_filter($resumes, function ($resume) use ($role) {
                return $resume -> getRatingsByRole($role);
            })
        );
        if ($count == 0) {
            return 1;
        }

        return $count;
    }

    /**
     * @Route("/statistic", name="show_statistic")
     * @param Request $request
     * @param AdditionalGlobalContext $additionalContext
     * @return Response
     */
    public function getStatistic(
        Request $request,
        AdditionalGlobalContext $additionalContext): Response
    {
        $user = $this -> getUser();
        $entityManager = $this->getDoctrine()->getManager();

        $vacancies = $entityManager
            -> getRepository(Vacancy::class)
            -> findAll()
        ;

        $vacancy = $request -> query -> get('vacancy');
        $start = $request -> query -> get('start');
        $end = $request -> query -> get('end');

        $start = DateTime::createFromFormat('Y-m-d\TH:i', $start);
        $end = DateTime::createFromFormat('Y-m-d\TH:i', $end);

        $activeRole = $additionalContext -> getActiveRole();
        $criteria = array('deleted' => false);
        if ($activeRole -> getCode() == Role::HR) {
            $criteria['hr'] = $user;
        }

        $resumes = $entityManager
            ->getRepository(Resume::class)
            ->findByRangeDate($criteria, $start, $end)
        ;

        if ($vacancy) {
            $resumes = array_filter($resumes, function (Resume $resume) use ($vacancy) {
                return $resume -> getVacancy() -> getId() == $vacancy;
            });
        }

        $result = array(
            'all' => count($resumes),
            'invite' => count(array_filter($resumes, function (Resume $resume) {
                return $resume -> getLastStatus() -> getStatus() -> getId() == Status::INVITE_STATUS;
            })),
            'refusing' => count(array_filter($resumes, function (Resume $resume) {
                return $resume -> getLastStatus() -> getStatus() -> getId() == Status::REFUSING_STATUS;
            })),
            'averageHR' => round(array_reduce($resumes, function ($carry, Resume $resume) {
                    $score = $resume -> getAverageRating(Role::HR);
                    if (!is_null($score)) {
                        $carry += $score;
                    }
                    return $carry;
                }, 0) / $this -> getCountResumes($resumes, Role::HR), 2),
            'averageCustomer' => round(array_reduce($resumes, function ($carry, Resume $resume) {
                    $score = $resume -> getAverageRating(Role::CUSTOMER);
                    if (!is_null($score)) {
                        $carry += $score;
                    }
                    return $carry;
                }, 0) / $this -> getCountResumes($resumes, Role::CUSTOMER), 2),
        );

        return $this->render(
            'statistic/show_statistic.html.twig',
            [
                'vacancies' => $vacancies,
                'result' => $result,
            ]
        );
    }
}