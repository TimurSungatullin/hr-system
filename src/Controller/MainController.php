<?php


namespace App\Controller;


use App\Entity\Resume;
use App\Entity\Role;
use App\Entity\Status;
use App\Entity\Vacancy;
use App\Services\AdditionalGlobalContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class MainController extends AbstractController
{

    /**
     * @Route("/home", name="main")
     * @param Request $request
     * @param AdditionalGlobalContext $additionalContext
     * @return Response
     */
    public function main(
        Request $request,
        AdditionalGlobalContext $additionalContext): Response
    {
        $user = $this -> getUser();
        $resumes = $user -> getActiveResumes();
        $activeRole = $additionalContext -> getActiveRole();
        # TODO Разные $resumes в зависимости от роли
        if ($activeRole -> getCode() == Role::CUSTOMER) {
            $resumes = $user -> getResumeToOwners();
        }

        $entityManager = $this->getDoctrine()->getManager();
        $statuses = $entityManager
            -> getRepository(Status::class)
            -> findAll()
        ;

        $vacancies = $entityManager
            -> getRepository(Vacancy::class)
            -> findAll()
        ;

        $status = $request -> query -> get('status');
        $vacancy = $request -> query -> get('vacancy');

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

        return $this -> render(
            'main/main.html.twig',
            [
                'resumes' => $resumes,
                'vacancies' => $vacancies,
                'statuses' => $statuses,
            ]
        );
    }

    /**
     * @Route("/change_role", name="change_role")
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function changeRole(
        Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $user = $this -> getUser();
        $roleId = $request->request->get('role');
        $cache = new FilesystemAdapter();
        $activeRole = $cache->getItem($user -> getId().'_active_role');
        $activeRole -> set($roleId);
        $cache -> save($activeRole);

        return new Response();
    }

}