<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CourseController extends AbstractController
{
    #[Route('/admin/course', name: 'course_index')]
    public function index(): Response
    {
        return $this->render('admin/course/index.html.twig', [
            'controller_name' => 'CourseController',
        ]);
    }
}