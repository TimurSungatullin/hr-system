<?php


namespace App\Controller;


use App\Entity\HistoryVacancy;
use App\Entity\Rating;
use App\Entity\Resume;
use App\Entity\Status;
use App\Entity\StatusHistory;
use App\Entity\User;
use App\Entity\Vacancy;
use App\Form\RatingFormType;
use App\Form\ResumeFormType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class RatingController
 * @package App\Controller
 * @Route("/rating")
 */
class RatingController extends AbstractController
{

    /**
     * @Route("/add_comment", name="add_comment")
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function addComment(
        Request $request,
        AuthenticationUtils $authenticationUtils,
        SerializerInterface $serializer): JsonResponse
    {
        $user = $this->getUser();
        $score = $request->request->get('rating');
        $statusId = $request->request->get('status');
        $resumeId = $request->request->get('resume');
        $comment = $request->request->get('comment');

        $entityManager = $this -> getDoctrine() -> getManager();

        $status = $entityManager
            -> getRepository(Status::class)
            -> find($statusId)
        ;

        if (!$status) {
            # TODO raise ошибки
        }

        $resume = $entityManager
            -> getRepository(Resume::class)
            -> find($resumeId)
        ;

        if (!$resume) {
            # TODO Ошибки
        }

        $rating = new Rating();
        # TODO Ошибки/Ассерты
        $rating
            -> setUser($user)
            -> setScore($score)
            -> setStatus($status)
            -> setResume($resume)
            -> setVacancy($resume -> getVacancy())
            -> setComment($comment)
        ;

        $entityManager -> persist($rating);

        $entityManager->flush();

        $json_rating = $serializer->serialize(
            $rating,
            'json',
            ['groups' => 'add_comment']
        );

        return $this->json($json_rating);
    }
}