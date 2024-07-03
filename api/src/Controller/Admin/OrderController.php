<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    #[Route('/admin/order', name: 'order_index')]
    public function index(): Response
    {
        return $this->render('admin/order/index.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }
}