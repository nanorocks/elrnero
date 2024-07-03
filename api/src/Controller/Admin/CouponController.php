<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CouponController extends AbstractController
{
    #[Route('/admin/coupons', name: 'coupon_index')]
    public function index(): Response
    {
        return $this->render('admin/coupon/index.html.twig', [
            'controller_name' => 'CouponController',
        ]);
    }
}