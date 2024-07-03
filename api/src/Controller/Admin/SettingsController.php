<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SettingsController extends AbstractController
{
    #[Route('/admin/settings', name: 'settings_index')]
    public function index(): Response
    {
        return $this->render('admin/settings/index.html.twig', [
            'controller_name' => 'SettingsController',
        ]);
    }
}