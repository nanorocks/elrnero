<?php

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class ApiLoginController extends AbstractController
{
    #[Route('/api/v1/login', name: 'api_login', methods: ['POST'])]
    public function index(#[CurrentUser] ?User $user, JWTTokenManagerInterface $jwtManager): JsonResponse
    {
        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        if($user->isBanned()) {
            throw new AccessDeniedHttpException('Banned profile.');
        }
        
        $token = $jwtManager->create($user);

        $payload = $jwtManager->parse($token);
     
        return $this->json([
            'user'  => $user->getUserIdentifier(),
            'access_token' =>  'Bearer ' . $token,
            'exp' => $payload['exp']
        ]);
    }
}