<?php


namespace App\Controller;


use App\Entity\Resume;
use App\Entity\Role;
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
     * @param AuthenticationUtils $authenticationUtils
     * @param AdditionalGlobalContext $additionalContext
     * @return Response
     */
    public function main(
        AuthenticationUtils $authenticationUtils,
        AdditionalGlobalContext $additionalContext): Response
    {
        $user = $this -> getUser();
        $resumes = $user -> getResumes();
        $activeRole = $additionalContext -> getActiveRole();
        # TODO Разные $resumes в зависимости от роли
        if ($activeRole -> getCode() == Role::CUSTOMER) {
            $resumes = $user -> getResumeToOwners();
        }

        return $this -> render(
            'main/main.html.twig',
            [
                'resumes' => $resumes,
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