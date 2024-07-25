<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MailServiceController extends AbstractController
{
    #[Route('/admin/mail-service', name: 'mail_service_index')]
    public function index(): Response
    {
        return $this->render('admin/mail_service/index.html.twig', [
            'controller_name' => 'MailServiceController',
        ]);
    }
}
