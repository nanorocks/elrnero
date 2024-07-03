<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FeedbackController extends AbstractController
{
    #[Route('admin/feedback', name: 'feedback_index')]
    public function index(): Response
    {
        return $this->render('admin/feedback/index.html.twig', [
            'controller_name' => 'FeedbackController',
        ]);
    }
}