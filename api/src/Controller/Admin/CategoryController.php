<?php

// src/Controller/Admin/CategoryController.php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class CategoryController extends AbstractController
{

    #[Route('/admin/categories', name: 'category_index')]
    public function index(CategoryRepository $categoryRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $queryBuilder = $categoryRepository->createQueryBuilder('c');

        // Handle filters
        if ($request->query->getAlnum('name')) {
            $queryBuilder->andWhere('c.name LIKE :name')
                ->setParameter('name', '%' . $request->query->getAlnum('name') . '%');
        }

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1), /* page number */
            10 /* limit per page */
        );

        return $this->render('/admin/category/index.html.twig', [
            'pagination' => $pagination,
            'filters' => $request->query->all(),
        ]);
    }

    #[Route('/admin/categories/new', name: 'category_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        // Fetch all categories to populate the parent category dropdown
        $allCategories = $entityManager->getRepository(Category::class)->findAll();


        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $description = $request->request->get('description');
            $avatarFile = $request->files->get('avatar');
            $parentId = $request->request->get('parent_id');

            $category = new Category();
            $category->setName($name);
            $category->setDescription($description);

            $slug = $slugger->slug($name)->lower();
            $category->setSlug($slug);

            if ($parentId) {
                $parent = $entityManager->getRepository(Category::class)->find($parentId);
                $category->setParent($parent);
            }

            if ($avatarFile) {
                $originalFilename = pathinfo($avatarFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $avatarFile->guessExtension();

                try {
                    $avatarFile->move(
                        $this->getParameter('avatars_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle exception if something happens during file upload
                }

                $category->setAvatar($newFilename);
            }

            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('admin/category/new.html.twig', [
            'allCategories' => $allCategories,
        ]);
    }

    #[Route('/admin/categories/{id}/edit', name: 'category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category, EntityManagerInterface $entityManager, SluggerInterface $slugger, CategoryRepository $categoryRepository): Response
    {
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $description = $request->request->get('description');
            $avatarFile = $request->files->get('avatar');
            $parentId = $request->request->get('parent_id');

            $category->setName($name);
            $category->setDescription($description);

            $slug = $slugger->slug($name)->lower();
            $category->setSlug($slug);

            if ($parentId) {
                $parent = $entityManager->getRepository(Category::class)->find($parentId);
                $category->setParent($parent);
            }

            if ($avatarFile) {
                $originalFilename = pathinfo($avatarFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $avatarFile->guessExtension();

                try {
                    $avatarFile->move(
                        $this->getParameter('avatars_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle exception if something happens during file upload

                }

                $category->setAvatar($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('admin/category/edit.html.twig', [
            'category' => $category,
            'allCategories' => $categoryRepository->findAll(),
        ]);
    }


    #[Route('/admin/categories/{id}', name: 'category_show')]
    public function show(Category $category): Response
    {
        return $this->render('admin/category/show.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/admin/categories/{id}/delete', name: 'category_delete', methods: ['POST'])]
    public function delete(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $category->getId(), $request->request->get('_token'))) {
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('category_index');
    }
}
