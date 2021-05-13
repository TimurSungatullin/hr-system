<?php


namespace App\Controller;


use App\Entity\HistoryVacancy;
use App\Entity\Meeting;
use App\Entity\Rating;
use App\Entity\Resume;
use App\Entity\ResumeToOwner;
use App\Entity\Role;
use App\Entity\Status;
use App\Entity\User;
use App\Entity\StatusHistory;
use App\Entity\Vacancy;
use App\Form\ResumeFormType;
use App\Services\ResumeParser;
use DateTime;
use Exception;
use IntlDateFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Exception\ValidatorException;

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
     * @return Response
     */
    public function addResume(Request $request): Response
    {
        $user = $this->getUser();

        $resume = new Resume();
        $form = $this->createForm(ResumeFormType::class, $resume);
        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();
        $error = '';
        try {
            if ($form->isSubmitted() && $form->isValid()) {
                $resume->setHr($user);

                $photo = $resume->filePhoto;

                if ($photo) {
                    $photoName = md5(uniqid()) . '.' . $photo->guessExtension();

                    $photo->move(
                        $_SERVER['UPLOAD_PHOTO_DIR'],
                        $photoName
                    );

                    $resume->setPhoto($photoName);
                }

                $vacancyId = $request->request->get('vacancy');

                if (!$vacancyId) {
                    $error = 'Необходимо выбрать вакансию';
                    throw new ValidatorException($error);
                }

                $vacancy = $entityManager
                    ->getRepository(Vacancy::class)
                    ->find($vacancyId);

                if (!$vacancy) {
                    $error = 'Такой вакансии нет';
                    throw new ValidatorException($error);
                }

                if (!$user->hasAccessVacancy($vacancy)) {
                    $error = 'Данный пользователь не может добавлять резюме с этой вакансией';
                    throw new ValidatorException($error);
                }

                $history = new HistoryVacancy();
                $history
                    ->setResume($resume)
                    ->setVacancy($vacancy)
                    ->setDate(new DateTime());

                $status = $entityManager
                    ->getRepository(Status::class)
                    ->find(Status::DEFAULT_STATUS);
                $history_status = new StatusHistory();
                $history_status
                    ->setResume($resume)
                    ->setStatus($status)
                    ->setAuthor($user);

                $entityManager->persist($resume);
                $entityManager->persist($history);
                $entityManager->persist($history_status);

                $entityManager->flush();


                return $this->redirectToRoute('main');
            }
        }
        catch (ValidatorException $ex) {
            $error = $ex -> getMessage();
        }

        return $this->render(
            'resume/add_resume.html.twig',
            [
                'form' => $form->createView(),
                'error' => $error,
            ]
        );
    }

    /**
     * @Route("/{id}", name="resume_detail", methods={"GET"})
     * @param string $id
     * @return Response
     */
    public function getResume(string $id): Response
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
            -> findByResume($id)
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
     * @param string $id
     * @return Response
     */
    public function deleteResume(string $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $resume = $entityManager
            -> getRepository(Resume::class)
            -> find($id)
        ;

        if (!$resume) {
        }

        $resume -> setDeleted(true);

        $entityManager -> persist($resume);
        $entityManager -> flush();

        return new Response();
    }

    /**
     * @Route("/send", name="send_resume")
     * @param Request $request
     * @return Response
     */
    public function sendResume(Request $request): Response
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

        foreach ($owners as $ownerId) {
            $owner = $entityManager
                -> getRepository(User::class)
                -> find($ownerId)
            ;

            if ($owner) {

                $entityManager
                    -> getRepository(ResumeToOwner::class)
                    -> findOrUpdate($resume, $owner);
            }

        }

        return new Response();
    }

    /**
     * @Route("/change_status", name="resume_change_status")
     * @param Request $request
     * @return Response
     */
    public function changeStatus(Request $request): Response
    {
        $user = $this->getUser();

        $statusId = $request->request->get('status');
        $resumeId = $request->request->get('resume');

        $entityManager = $this->getDoctrine()->getManager();
        $status = $entityManager
            -> getRepository(Status::class)
            -> find($statusId)
        ;

        $resume = $entityManager
            -> getRepository(Resume::class)
            -> find($resumeId)
        ;

        $history = new StatusHistory();
        $history
            -> setResume($resume)
            -> setStatus($status)
            -> setAuthor($user)
        ;

        $entityManager -> persist($history);

        $entityManager -> flush();

        return new Response();

    }

    /**
     * @Route("/invite", name="invite")
     * @param Request $request
     * @return Response
     */
    public function inviteToMeet(Request $request): Response
    {
        $users = $request->request->get('users');
        $resumeId = $request->request->get('resume');
        $date = $request->request->get('date');

        $entityManager = $this->getDoctrine()->getManager();
        $resume = $entityManager
            -> getRepository(Resume::class)
            -> find($resumeId)
        ;

        if (!$resume) {
            #TODO raise 404 ошибки или редирект на главную с сообщением
        }

        $date = Datetime::createFromFormat('Y-m-d\TH:i', $date);

        if (!$date) {
            # TODO некорректная дата
        }

        $meet = new Meeting();
        $meet
            -> setResume($resume)
            -> setDateMeet($date)
        ;

        foreach ($users as $userId) {
            $user = $entityManager
                -> getRepository(User::class)
                -> find($userId)
            ;

            if ($user) {
                $meet -> addUser($user);
            }
        }

        $entityManager -> persist($meet);
        $entityManager -> flush();

        return new Response();
    }

    /**
     * @Route("/load", name="load_resume")
     * @param Request $request
     * @return JsonResponse
     */
    public function loadResume(Request $request): JsonResponse
    {
        $file = $request->files->get('file');
        $fileName = md5(uniqid()) . '.' . $file -> guessExtension();
        $file->move(
            $_SERVER['UPLOAD_FILE_DIR'],
            $fileName
        );
        $html = file_get_contents($_SERVER['UPLOAD_FILE_DIR'] . '/' . $fileName);

        $resume = ResumeParser::parse($html);

        return $this->json($resume);
    }
}