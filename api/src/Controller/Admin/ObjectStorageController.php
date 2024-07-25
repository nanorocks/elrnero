<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ObjectStorageController extends AbstractController
{
    #[Route('/admin/object-storage', name: 'object_storage_index')]
    public function index(): Response
    {
        return $this->render('admin/object_storage/index.html.twig', [
            'controller_name' => 'ObjectStorageController',
        ]);
    }
}