<?php

// src/Controller/Admin/CategoryController.php

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/admin/categories', name: 'app_admin_categories')]
    public function index(): Response
    {
        return $this->render('admin/category/index.html.twig', [
            'datatable' => null,
        ]);
    }
}