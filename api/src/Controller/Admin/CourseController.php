<?php

namespace App\Controller\Admin;

use App\Entity\Course;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class CourseController extends AbstractController
{
    #[Route('/admin/courses', name: 'course_index')]
    public function index(CourseRepository $courseRepository): Response
    {
        return $this->render('/admin/course/index.html.twig', [
            'courses' => $courseRepository->findAll(),
        ]);
    }

    #[Route('/admin/courses/new', name: 'course_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        // Fetch all courses to populate the parent course dropdown
        $allCourses = $entityManager->getRepository(Course::class)->findAll();


        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $description = $request->request->get('description');
            $avatarFile = $request->files->get('avatar');
            $parentId = $request->request->get('parent_id');

            $course = new Course();
            $course->setName($name);
            $course->setDescription($description);

            $slug = $slugger->slug($name)->lower();
            $course->setSlug($slug);
            
            if ($parentId) {
                $parent = $entityManager->getRepository(Course::class)->find($parentId);
                $course->setParent($parent);
            }

            if ($avatarFile) {
                $originalFilename = pathinfo($avatarFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $avatarFile->guessExtension();

                try {
                    $avatarFile->move(
                        $this->getParameter('avatars_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle exception if something happens during file upload
                }

                $course->setAvatar($newFilename);
            }

            $entityManager->persist($course);
            $entityManager->flush();

            return $this->redirectToRoute('course_index');
        }

        return $this->render('admin/course/new.html.twig', [
            'allCourses' => $allCourses,
        ]);
    }

    #[Route('/admin/courses/{id}/edit', name: 'course_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Course $course, EntityManagerInterface $entityManager, SluggerInterface $slugger, CourseRepository $courseRepository): Response
    {
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $description = $request->request->get('description');
            $avatarFile = $request->files->get('avatar');
            $parentId = $request->request->get('parent_id');

            $course->setName($name);
            $course->setDescription($description);

            $slug = $slugger->slug($name)->lower();
            $course->setSlug($slug);

            if ($parentId) {
                $parent = $entityManager->getRepository(course::class)->find($parentId);
                $course->setParent($parent);
            }

            if ($avatarFile) {
                $originalFilename = pathinfo($avatarFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $avatarFile->guessExtension();

                try {
                    $avatarFile->move(
                        $this->getParameter('avatars_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle exception if something happens during file upload

                }

                $course->setAvatar($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('course_index');
        }

        return $this->render('admin/course/edit.html.twig', [
            'course' => $course,
            'allCourses' => $courseRepository->findAll(),
        ]);
    }


    #[Route('/admin/courses/{id}', name: 'course_show')]
    public function show(Course $course): Response
    {
        return $this->render('admin/course/show.html.twig', [
            'course' => $course,
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