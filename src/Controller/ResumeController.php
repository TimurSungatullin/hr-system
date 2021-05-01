<?php


namespace App\Controller;


use App\Entity\HistoryVacancy;
use App\Entity\Rating;
use App\Entity\Resume;
use App\Entity\ResumeToOwner;
use App\Entity\Role;
use App\Entity\Status;
use App\Entity\User;
use App\Entity\StatusHistory;
use App\Entity\Vacancy;
use App\Form\ResumeFormType;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class ResumeController
 * @package App\Controller
 * @Route("/resume")
 */
class ResumeController extends AbstractController
{

    /**
     * @Route("/add", name="add_resume")
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function addResume(
        Request $request,
        AuthenticationUtils $authenticationUtils): Response
    {
        # TODO только для hr
        $user = $this->getUser();

        $resume = new Resume();
        $form = $this->createForm(ResumeFormType::class, $resume);
        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $resume -> setHr($user);

            $photo = $resume->filePhoto;

            $photoName = md5(uniqid()) . '.' . $photo -> guessExtension();

            $photo->move(
                $_SERVER['UPLOAD_FILE_DIR'],
                $photoName
            );

            $resume -> setPhoto($photoName);

            $vacancyId = $request->request->get('vacancy');
            $vacancy = $entityManager
                -> getRepository(Vacancy::class)
                -> find($vacancyId)
            ;
            if (!$vacancy) {
                $error = 'Такой вакансии нет';
            }

            if (!$user -> hasAccessVacancy($vacancy)) {
                # TODO try/catch?
                $error = 'Данные пользователь не может добавлять резюме с этой вакансией';
            }

            $history = new HistoryVacancy();
            $history
                -> setResume($resume)
                -> setVacancy($vacancy)
                -> setDate(new DateTime())
            ;

            $status = $entityManager
                -> getRepository(Status::class)
                -> find(Status::DEFAULT_STATUS)
            ;
            $history_status = new StatusHistory();
            $history_status
                -> setResume($resume)
                -> setStatus($status)
            ;

            $entityManager -> persist($resume);
            $entityManager -> persist($history);
            $entityManager -> persist($history_status);

            $entityManager->flush();


            return $this->redirectToRoute('main');
        }

        return $this->render(
            'resume/add_resume.html.twig',
            [
                'form' => $form->createView(),
                'error' => $form->getErrors(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="resume_detail", methods={"GET"})
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @param string $id
     * @return Response
     */
    public function getResume(
        Request $request,
        AuthenticationUtils $authenticationUtils,
        string $id): Response
    {
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $resume = $entityManager
            -> getRepository(Resume::class)
            -> find($id)
        ;

        $statuses = $entityManager
            -> getRepository(Status::class)
            -> findAll()
        ;

        if (!$resume) {
            #TODO raise 404 ошибки или редирект на главную с сообщением
        }

        $ratings = $entityManager
            -> getRepository(Rating::class)
            -> findByResume($resume)
        ;

        $owners = $entityManager
            -> getRepository(User::class)
            -> findByRole(Role::CUSTOMER)
        ;

        $users = $entityManager
            -> getRepository(User::class)
            -> findExcludeOne($user -> getId());

        return $this->render(
            'resume/resume_detail.html.twig',
            [
                'resume' => $resume,
                'statuses' => $statuses,
                'ratings' => $ratings,
                'owners' => $owners,
                'users' => $users,
            ]
        );
    }

    /**
     * @Route("/{id}", name="resume_delete", methods={"DELETE"})
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @param string $id
     * @return Response
     */
    public function deleteResume(
        Request $request,
        AuthenticationUtils $authenticationUtils,
        string $id): Response
    {

    }

    /**
     * @Route("/send", name="send_resume")
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function sendResume(
        Request $request,
        AuthenticationUtils $authenticationUtils): Response
    {
        $user = $this->getUser();
        $owners = $request->request->get('owners');
        $resumeId = $request->request->get('resume');

        $entityManager = $this->getDoctrine()->getManager();
        $resume = $entityManager
            -> getRepository(Resume::class)
            -> find($resumeId)
        ;

        if (!$resume) {
            #TODO raise 404 ошибки или редирект на главную с сообщением
        }

        $owners = explode(',', $owners);

        foreach ($owners as $ownerId) {
            $owner = $entityManager
                -> getRepository(User::class)
                -> find($ownerId)
            ;

            if ($owner) {
                $resumeToOwner = new ResumeToOwner();
                $resumeToOwner
                    -> setResume($resume)
                    -> setOwner($owner)
                ;

                $entityManager -> persist($resumeToOwner);

                $entityManager->flush();
            }

        }

        return new Response();
    }
}