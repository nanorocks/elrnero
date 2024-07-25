<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Course;
use App\Enum\LevelEnum;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class CourseController extends AbstractController
{
    #[Route('/admin/courses', name: 'course_index')]
    public function index(CourseRepository $courseRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $levels = LevelEnum::getAllLevels();

        $queryBuilder = $courseRepository->createQueryBuilder('c')->orderBy('c.id', 'ASC');

        // Handle filters
        if ($request->query->getAlnum('name')) {
            $queryBuilder->andWhere('c.name LIKE :name')
                ->setParameter('name', '%' . $request->query->getAlnum('name') . '%');
        }

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1), /* page number */
            10 /* limit per page */
        );
        
        return $this->render('/admin/course/index.html.twig', [
            'pagination' => $pagination,
            'filters' => $request->query->all(),
            'levels' => $levels
        ]);
    }

    #[Route('/admin/courses/new', name: 'course_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        // Fetch all courses to populate the parent course dropdown
        $levels = LevelEnum::getAllLevels();
        $allUsers = $entityManager->getRepository(User::class)->findAll();

        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $description = $request->request->get('description');
            $lastUpdated = $request->request->get('last_updated');
            $language = $request->request->get('language');
            $totalHours = $request->request->get('total_hours');
            $totalVideos = $request->request->get('total_videos');
            $totalArticles = $request->request->get('total_articles');
            $downloadableResources = $request->request->get('downloadable_resources');
            $price = $request->request->get('price');
            $percentageDiscountForPrice = $request->request->get('percentage_discount_for_price');
            $multiPlatformAccess = $request->request->get('multi_platform_access') ?? false;
            $hasCertificate = $request->request->get('has_certificate') ?? false;
            $isPublished = $request->request->get('is_published') ?? false;
            $level = $request->request->get('level');
            $totalStudents = $request->request->get('total_students');
            $tags = $request->request->get('tags');
            $video_thumbnail = $request->files->get('video_thumbnail');
            $user_id = $request->request->get('user_id');

            $course = new Course();
            $user = $entityManager->getRepository(User::class)->find($user_id);

            $course->setName($name);
            $course->setDescription($description);
            $course->setLastUpdated(\DateTime::createFromFormat('Y-m-d', $lastUpdated));
            $course->setLanguage($language);
            $course->setTotalHours($totalHours);
            $course->setTotalVideos($totalVideos);
            $course->setTotalArticles($totalArticles);
            $course->setDownloadableResources($downloadableResources);
            $course->setPrice($price);
            $course->setPercentageDiscountForPrice($percentageDiscountForPrice);
            $course->setMultiPlatformAccess($multiPlatformAccess);
            $course->setHasCertificate($hasCertificate);
            $course->setPublished($isPublished);
            $course->setLevel($level);
            $course->setTotalStudents($totalStudents);
            $course->setUser($user);

            $slug = $slugger->slug($name)->lower();
            $course->setSlug($slug);

            if ($tags) {
                $course->setTags(explode(',', trim($tags)));
            }

            if ($video_thumbnail) {
                $originalFilename = pathinfo($video_thumbnail->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $video_thumbnail->guessExtension();

                try {
                    $video_thumbnail->move(
                        $this->getParameter('avatars_directory') . '/courses/',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle exception if something happens during file upload

                }

                $course->setVideoThumbnail($newFilename);
            }


            $entityManager->persist($course);
            $entityManager->flush();

            return $this->redirectToRoute('course_index');
        }

        return $this->render('admin/course/new.html.twig', [
            'levels' => $levels,
            'allUsers' => $allUsers
        ]);
    }

    #[Route('/admin/courses/{id}/edit', name: 'course_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Course $course, EntityManagerInterface $entityManager, SluggerInterface $slugger, CourseRepository $courseRepository): Response
    {
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $description = $request->request->get('description');
            $lastUpdated = $request->request->get('last_updated');
            $language = $request->request->get('language');
            $totalHours = $request->request->get('total_hours');
            $totalVideos = $request->request->get('total_videos');
            $totalArticles = $request->request->get('total_articles');
            $downloadableResources = $request->request->get('downloadable_resources');
            $price = $request->request->get('price');
            $percentageDiscountForPrice = $request->request->get('percentage_discount_for_price');
            $multiPlatformAccess = $request->request->get('multi_platform_access') ?? false;
            $hasCertificate = $request->request->get('has_certificate') ?? false;
            $isPublished = $request->request->get('is_published') ?? false;
            $level = $request->request->get('level');
            $totalStudents = $request->request->get('total_students');
            $tags = $request->request->get('tags');
            $video_thumbnail = $request->files->get('video_thumbnail');
            $user_id = $request->request->get('user_id');

            $user = $entityManager->getRepository(User::class)->find($user_id);

            $course->setName($name);
            $course->setDescription($description);
            $course->setLastUpdated(\DateTime::createFromFormat('Y-m-d', $lastUpdated));
            $course->setLanguage($language);
            $course->setTotalHours($totalHours);
            $course->setTotalVideos($totalVideos);
            $course->setTotalArticles($totalArticles);
            $course->setDownloadableResources($downloadableResources);
            $course->setPrice($price);
            $course->setPercentageDiscountForPrice($percentageDiscountForPrice);
            $course->setMultiPlatformAccess($multiPlatformAccess);
            $course->setHasCertificate($hasCertificate);
            $course->setPublished($isPublished);
            $course->setLevel($level);
            $course->setTotalStudents($totalStudents);
            $course->setUser($user);

            $slug = $slugger->slug($name)->lower();
            $course->setSlug($slug);

            if ($tags) {
                $course->setTags(explode(',', trim($tags)));
            }

            if ($video_thumbnail) {
                $originalFilename = pathinfo($video_thumbnail->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $video_thumbnail->guessExtension();

                try {
                    $video_thumbnail->move(
                        $this->getParameter('avatars_directory') . '/courses/',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle exception if something happens during file upload

                }

                $course->setVideoThumbnail($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('course_index', [
                'page' => $request->query->get('page')
            ]);
        }

        $levels = LevelEnum::getAllLevels();
        $allUsers = $entityManager->getRepository(User::class)->findAll();

        return $this->render('admin/course/edit.html.twig', [
            'course' => $course,
            'levels' => $levels,
            'allUsers' => $allUsers
        ]);
    }


    #[Route('/admin/courses/{id}', name: 'course_show')]
    public function show(Course $course): Response
    {
        $level = LevelEnum::getNameByValue($course->getLevel());

        return $this->render('admin/course/show.html.twig', [
            'course' => $course,
            'level' => $level
        ]);
    }

    #[Route('/admin/courses/{id}/delete', name: 'course_delete', methods: ['POST'])]
    public function delete(Request $request, Course $course, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $course->getId(), $request->request->get('_token'))) {
            $entityManager->remove($course);
            $entityManager->flush();
        }

        return $this->redirectToRoute('course_index');
    }
}