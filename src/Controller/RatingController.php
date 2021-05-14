<?php


namespace App\Controller;


use App\Entity\Rating;
use App\Entity\Resume;
use App\Entity\Status;
use App\Services\AdditionalGlobalContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

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
     * @param AdditionalGlobalContext $additionalContext
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function addComment(
        Request $request,
        AdditionalGlobalContext $additionalContext,
        SerializerInterface $serializer): JsonResponse
    {
        $user = $this->getUser();
        $score = $request->request->get('rating');
        $statusId = $request->request->get('status');
        $resumeId = $request->request->get('resume');
        $comment = $request->request->get('comment');

        $entityManager = $this -> getDoctrine() -> getManager();

        if (!$statusId) {
            throw new ValidatorException('Необхимо выбрать статус');
        }

        $status = $entityManager
            -> getRepository(Status::class)
            -> find($statusId)
        ;

        if (!$status) {
            throw new ValidatorException('Статус не найден');
        }

        $resume = $entityManager
            -> getRepository(Resume::class)
            -> find($resumeId)
        ;

        if (!$resume) {
            throw new ValidatorException('Резюме не найдено');
        }

        $rating = new Rating();
        $rating
            -> setUser($user)
            -> setScore($score)
            -> setStatus($status)
            -> setResume($resume)
            -> setVacancy($resume -> getVacancy())
            -> setComment($comment)
            -> setRole($additionalContext -> getActiveRole())
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

    /**
     * @Route("/get_comments", name="get_comments")
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function getComments(
        Request $request,
        SerializerInterface $serializer): JsonResponse
    {
        $start = $request->request->get('start');
        $resumeId = $request->request->get('resume');
        $limit = 10;

        $entityManager = $this -> getDoctrine() -> getManager();
        $resume = $entityManager
            -> getRepository(Resume::class)
            -> find($resumeId)
        ;

        if (!$resume) {
            # TODO Ошибки
        }

        $ratings = $entityManager
            -> getRepository(Rating::class)
            -> findByResume(
                $resumeId,
                $limit,
                $start
            )
        ;

        $json_rating = $serializer->serialize(
            $ratings,
            'json',
            ['groups' => 'add_comment']
        );

        return $this->json($json_rating);

    }
}