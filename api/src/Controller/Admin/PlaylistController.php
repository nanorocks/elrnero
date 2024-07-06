<?php

namespace App\Controller\Admin;

use ErrorException;
use App\Entity\User;
use App\Entity\Playlist;
use App\Repository\UserRepository;
use App\Repository\PlaylistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class PlaylistController extends AbstractController
{
  
    #[Route('/admin/playlist', name: 'playlist_index')]
    public function index(PlaylistRepository $playlistRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $queryBuilder = $playlistRepository->findAllWithUsersQuery();

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
        
        return $this->render('/admin/playlist/index.html.twig', [
            'pagination' => $pagination,
            'filters' => $request->query->all(),
        ]);
    }

    #[Route('/admin/playlist/new', name: 'playlist_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Fetch all users to populate the parent playlist dropdown
        $allUsers = $entityManager->getRepository(User::class)->findAll();


        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $created_at = $request->request->get('created_at');
            $user_id = $request->request->get('user_id');

            $user = $entityManager->getRepository(User::class)->find($user_id);

            $playlist = new Playlist();
            $playlist->setName($name);
            $playlist->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $created_at));

            if ($user !== null) {
                $playlist->setUser($user);
            } else {
                throw new NotFoundHttpException('User is invalid!');
            }

            $entityManager->persist($playlist);
            $entityManager->flush();

            return $this->redirectToRoute('playlist_index');
        }

        return $this->render('admin/playlist/new.html.twig', [
            'allUsers' => $allUsers,
        ]);
    }

    #[Route('/admin/playlist/{id}/edit', name: 'playlist_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Playlist $playlist, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $created_at = $request->request->get('created_at');
            $user_id = $request->request->get('user_id');

            $playlist->setName($name);
            $playlist->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $created_at));

            $user = $entityManager->getRepository(User::class)->find($user_id);

            if ($user !== null) {
                $playlist->setUser($user);
            } else {
                throw new NotFoundHttpException('User is invalid!');
            }

            $entityManager->flush();

            return $this->redirectToRoute('playlist_index');
        }

        return $this->render('admin/playlist/edit.html.twig', [
            'playlist' => $playlist,
            'allUsers' => $userRepository->findAll(),
        ]);
    }


    #[Route('/admin/playlist/{id}', name: 'playlist_show')]
    public function show(Playlist $playlist): Response
    {
        return $this->render('admin/playlist/show.html.twig', [
            'playlist' => $playlist,
        ]);
    }

    #[Route('/admin/playlist/{id}/delete', name: 'playlist_delete', methods: ['POST'])]
    public function delete(Request $request, Playlist $playlist, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $playlist->getId(), $request->request->get('_token'))) {
            $entityManager->remove($playlist);
            $entityManager->flush();
        }

        return $this->redirectToRoute('playlist_index');
    }
}