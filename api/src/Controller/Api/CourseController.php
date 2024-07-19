<?php

namespace App\Controller\Api;

use App\Entity\Course;
use App\Enum\LevelEnum;
use App\Entity\Category;
use App\Repository\CourseRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controller\Api\TokenAuthenticatedController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CourseController extends AbstractController implements TokenAuthenticatedController
{
    public function __construct(
        private Security $security,
    ){
    }
    
    #[Route('/api/courses', name: 'app_api_courses', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, SerializerInterface $serializer, PaginatorInterface $paginator, Request $request): JsonResponse
    {
        // Fetch courses from the database
        $queryBuilder = $entityManager->getRepository(Course::class)->createQueryBuilder('c');

        // Paginate the results of the query
        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1), /* page number */
            $request->query->getInt('limit', 10) /* limit per page */
        );

        // Serialize paginated data to JSON
        $jsonData = $serializer->serialize($pagination->getItems(), 'json', ['groups' => 'course:read']);

        // Include pagination information
        $paginationData = [
            'items' => json_decode($jsonData, true),
            'total' => $pagination->getTotalItemCount(),
            'current_page' => $pagination->getCurrentPageNumber(),
            'limit_per_page' => $pagination->getItemNumberPerPage(),
        ];

        // Return JSON response
        return new JsonResponse($paginationData, JsonResponse::HTTP_OK);
    }
}