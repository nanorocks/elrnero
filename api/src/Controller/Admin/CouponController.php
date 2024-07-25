<?php

namespace App\Controller\Admin;

use App\Entity\Coupon;
use App\Entity\Course;
use App\Repository\CouponRepository;
use App\Repository\CategoryRepository;
use App\Utils;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class CouponController extends AbstractController
{
    #[Route('/admin/coupons', name: 'coupon_index')]
    public function index(Request $request, CouponRepository $couponRepository, PaginatorInterface $paginator): Response
    {
        $queryBuilder = $couponRepository->createQueryBuilder('c')->orderBy('c.id', 'ASC');

        // Handle filters
        if ($request->query->getAlnum('code')) {
            $queryBuilder->andWhere('c.code LIKE :code')
                ->setParameter('code', '%' . $request->query->getAlnum('code') . '%');
        }

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1), /* page number */
            10 /* limit per page */
        );

        return $this->render('/admin/coupon/index.html.twig', [
            'pagination' => $pagination,
            'filters' => $request->query->all(),
        ]);
    }

    #[Route('/admin/coupons/new', name: 'coupon_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        // Fetch all courses for dropdown
        $allCourses = $entityManager->getRepository(Course::class)->findAll();

        if ($request->isMethod('POST')) {
            $totalCoupons = $request->request->get('total_coupons');
            $absoluteDiscount = $request->request->get('absolute_discount');
            $courseId = $request->request->get('course_id');

            if ($totalCoupons) {

                $course = $entityManager->getRepository(Course::class)->find($courseId);

                for ($i = 0; $i < $totalCoupons; $i++) {
                    $coupon = new Coupon();
                    $coupon->setAbsoluteDiscount($absoluteDiscount);
                    $coupon->setCode(Utils::generateCouponCode());
                    $coupon->setValid(true);


                    $coupon->setCourse($course);

                    $entityManager->persist($coupon);
                }

                $entityManager->flush();
            }

            return $this->redirectToRoute('coupon_index');
        }

        return $this->render('admin/coupon/new.html.twig', [
            'allCourses' => $allCourses,
        ]);
    }

    #[Route('/admin/coupons/{id}/edit', name: 'coupon_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Coupon $coupon, EntityManagerInterface $entityManager, SluggerInterface $slugger, CategoryRepository $categoryRepository): Response
    {
       
        if ($request->isMethod('POST')) {
            $code = $request->request->get('code');
            $absoluteDiscount = $request->request->get('absolute_discount');
            $courseId = $request->request->get('course_id');
            $isValid = $request->request->get('is_valid') ?? false;

            $course = $entityManager->getRepository(Course::class)->find($courseId);

            $coupon->setAbsoluteDiscount($absoluteDiscount);
            $coupon->setCode($code);
            $coupon->setValid($isValid);
            $coupon->setCourse($course);

            $entityManager->persist($coupon);

            $entityManager->flush();

            return $this->redirectToRoute('coupon_index', [
                'page' => $request->query->get('page')
            ]);
        }

        $allCourses = $entityManager->getRepository(Course::class)->findAll();

        return $this->render('admin/coupon/edit.html.twig', [
            'coupon' => $coupon,
            'allCourses' => $allCourses,
        ]);
    }


    #[Route('/admin/coupons/{id}', name: 'coupon_show')]
    public function show(Coupon $coupon): Response
    {
        return $this->render('admin/coupon/show.html.twig', [
            'coupon' => $coupon,
        ]);
    }

    #[Route('/admin/coupons/{id}/delete', name: 'coupon_delete', methods: ['POST'])]
    public function delete(Request $request, Coupon $coupon, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $coupon->getId(), $request->request->get('_token'))) {
            $entityManager->remove($coupon);
            $entityManager->flush();
        }

        return $this->redirectToRoute('coupon_index');
    }
}