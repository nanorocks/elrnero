<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProfileController extends AbstractController
{
    #[Route('/admin/profile', name: 'profile_index', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, Security $security, UserRepository $userRepository): Response
    {
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $email = $request->request->get('email');
            $is_banned = $request->request->get('is_banned') ?? false;
            $bio = $request->request->get('short_bio');
            $avatarFile = $request->files->get('avatar');
            $job_title = $request->request->get('job_title');
            $soc_media = $request->request->get('soc_media');
            
            $user = $userRepository->findOneByEmail($email);
            
            $user->setName($name);
            $user->setEmail($email);
            $user->setBanned($is_banned);
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

            return $this->redirectToRoute('profile_index');
        }
        
        return $this->render('admin/profile/index.html.twig', [
            'user' => $security->getUser(),
        ]);
    }
}