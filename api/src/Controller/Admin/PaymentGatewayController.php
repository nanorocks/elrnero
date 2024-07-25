<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PaymentGatewayController extends AbstractController
{
    #[Route('/admin/payment-gateway', name: 'payment_gateway_index')]
    public function index(): Response
    {
        return $this->render('admin/payment_gateway/index.html.twig', [
            'controller_name' => 'PaymentGatewayController',
        ]);
    }
}
