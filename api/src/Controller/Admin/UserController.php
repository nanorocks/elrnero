<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UserController extends AbstractController
{
    #[Route('/admin/users', name: 'user_index')]
    public function index(EntityManagerInterface $entityManager,): Response
    {
        $allUsers = $entityManager->getRepository(User::class)->findAll();

        return $this->render('/admin/user/index.html.twig', [
            'users' => $allUsers,
        ]);
    }

    #[Route('/admin/users/new', name: 'user_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        // Fetch all categories to populate the parent category dropdown
        $allUsers = $entityManager->getRepository(User::class)->findAll();

        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $email = $request->request->get('email');
            $is_admin = $request->request->get('is_admin') ?? false;
            $bio = $request->request->get('bio');
            $avatarFile = $request->files->get('avatar');
            $job_title = $request->request->get('job_title');
            $soc_media = $request->request->get('soc_media');

            $user = new User();
            $user->setName($name);
            $user->setEmail($email);
            $user->setAdmin($is_admin);
            $user->setShortBio($bio);
            $user->setJobTitle($job_title);
            $user->setPassword(md5('fake_pass_no_login'));

            if ($soc_media) {
                $user->setSocMedia(explode(',', trim($soc_media)));
            }

            if ($avatarFile) {
                $originalFilename = pathinfo($avatarFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $avatarFile->guessExtension();

                try {
                    $avatarFile->move(
                        $this->getParameter('avatars_directory') . '/users/',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle exception if something happens during file upload
                }

                $user->setAvatar($newFilename);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('admin/user/new.html.twig', [
            'allUsers' => $allUsers,
        ]);
    }

    #[Route('/admin/users/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, SluggerInterface $slugger, UserRepository $userRepository): Response
    {
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $email = $request->request->get('email');
            $is_admin = $request->request->get('is_admin') ?? false;
            $bio = $request->request->get('bio');
            $avatarFile = $request->files->get('avatar');
            $job_title = $request->request->get('job_title');
            $soc_media = $request->request->get('soc_media');

            $user->setName($name);
            $user->setEmail($email);
            $user->setAdmin($is_admin);
            $user->setShortBio($bio);
            $user->setJobTitle($job_title);

            if ($soc_media) {
                $user->setSocMedia(explode(',', trim($soc_media)));
            }

            if ($avatarFile) {
                $originalFilename = pathinfo($avatarFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $avatarFile->guessExtension();

                try {
                    $avatarFile->move(
                        $this->getParameter('avatars_directory') . '/users/',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle exception if something happens during file upload

                }

                $user->setAvatar($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'allUsers' => $userRepository->findAll(),
        ]);
    }


    #[Route('/admin/users/{id}', name: 'user_show')]
    public function show(User $user): Response
    {
        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/admin/users/{id}/delete', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            // dd($user);
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}