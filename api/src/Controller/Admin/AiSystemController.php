<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AiSystemController extends AbstractController
{
    #[Route('/admin/ai-system', name: 'ai_system_index')]
    public function index(): Response
    {
        return $this->render('admin/ai_system/index.html.twig', [
            'controller_name' => 'AiSystemController',
        ]);
    }
}