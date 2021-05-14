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

        $status = $request -> query -> get('status');
        $vacancy = $request -> query -> get('vacancy');
        $entityManager = $this->getDoctrine()->getManager();


        $activeRole = $additionalContext -> getActiveRole();
        if ($activeRole -> getCode() == Role::CUSTOMER) {
            $resumes = $user -> getResumeToOwners($status, $vacancy);
        }
        elseif ($activeRole -> getCode() == Role::ADMIN) {
            $resumes = $entityManager
                ->getRepository(Resume::class)
                ->findBy(['deleted' => False]);
        }
        else {
            $resumes = $user -> getActiveResumes($status, $vacancy);
        }

        $statuses = $entityManager
            -> getRepository(Status::class)
            -> findAll()
        ;

        $vacancies = $entityManager
            -> getRepository(Vacancy::class)
            -> findAll()
        ;

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