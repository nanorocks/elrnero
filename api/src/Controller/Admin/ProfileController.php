<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{
    #[Route('/admin/profile', name: 'profile_index')]
    public function index(): Response
    {
        return $this->render('admin/profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }
}