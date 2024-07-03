<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlaylistController extends AbstractController
{
    #[Route('/admin/playlist', name: 'playlist_index')]
    public function index(): Response
    {
        return $this->render('admin/playlist/index.html.twig', [
            'controller_name' => 'PlaylistController',
        ]);
    }
}