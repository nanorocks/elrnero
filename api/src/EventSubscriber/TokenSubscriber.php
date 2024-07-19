<?php

// src/EventSubscriber/TokenSubscriber.php
namespace App\EventSubscriber;

use Exception;
use App\Repository\UserRepository;
use Symfony\Component\HttpKernel\KernelEvents;
use App\Controller\TokenAuthenticatedController;
use Http\Client\Exception\HttpException;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class TokenSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private JWTTokenManagerInterface $jwtManager,
        private UserRepository $userRepository
    ) {
    }
    
    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $event->getController();

        // when a controller class defines multiple action methods, the controller
        // is returned as [$controllerInstance, 'methodName']
        if (is_array($controller)) {
            $controller = $controller[0];
        }

        if ($controller instanceof \App\Controller\Api\TokenAuthenticatedController) {

            $request = $event->getRequest();
            $authorizationHeader = $request->headers->get('Authorization');
            $token = null;

            $token = $authorizationHeader;
          
            if (!$token) {
                throw new AccessDeniedHttpException('This action needs a valid token!');
            }

            $token = explode(' ', $token);        
            $token = $token[1];
           
            try {
              
                $payload = $this->jwtManager->parse($token);
        
                if (!$payload || !isset($payload['username'])) {
                    throw new AccessDeniedHttpException('Invalid credentials.');
                }

                // Check the token expiration
                if (isset($payload['exp'])) {
                    $exp = $payload['exp'];
                    $currentTime = time();
                    if ($exp < $currentTime) {
                        throw new AccessDeniedHttpException('Token has expired.');
                    }
                } else {
                    throw new AccessDeniedHttpException('Invalid token: no expiration.');
                }

                // Find the user by their identifier (email or another unique identifier)
                $user = $this->userRepository->findOneBy(['email' => $payload['username']]);
 
                if (null === $user) {
                    throw new AccessDeniedHttpException('Invalid credentials.');
                }

                if($user->isBanned()) {
                    throw new AccessDeniedHttpException('Invalid credentials.');
                }
                
            } catch (JWTDecodeFailureException $e) {
                throw new AccessDeniedHttpException($e->getMessage());
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}