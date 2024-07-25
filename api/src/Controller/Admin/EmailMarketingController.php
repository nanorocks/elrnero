<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EmailMarketingController extends AbstractController
{
    #[Route('/admin/email-marketing', name: 'email_marketing_index')]
    public function index(): Response
    {
        return $this->render('admin/email_marketing/index.html.twig', [
            'controller_name' => 'EmailMarketingController',
        ]);
    }
}