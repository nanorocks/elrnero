<?php

// src/Security/UserProvider.php
namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use App\DBAL\MultiDbConnectionWrapper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class UserProvider implements UserProviderInterface, PasswordUpgraderInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private RequestStack $requestStack,
        private EntityManagerInterface $em
    ) {
    }

    /**
     * Symfony calls this method if you use features like switch_user
     * or remember_me. If you're not using these features, you do not
     * need to implement this method.
     *
     * @throws UserNotFoundException if the user is not found
     */
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $this->setTenantConnection();
        
        // Load user based on identifier (email in this case)
        $user = $this->userRepository->loadUserByIdentifier($identifier);

        if (!$user) {
            throw new UserNotFoundException(sprintf('User "%s" not found.', $identifier));
        }

        return $user;
    }

    /**
     * Refreshes the user after being reloaded from the session.
     *
     * When a user is logged in, at the beginning of each request, the
     * User object is loaded from the session and then this method is
     * called. Your job is to make sure the user's data is still fresh by,
     * for example, re-querying for fresh User data.
     *
     * If your firewall is "stateless: true" (for a pure API), this
     * method is not called.
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        $this->setTenantConnection();
        
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
        }

        // Refresh user object here, if needed
        $loadedUser = $this->userRepository->find($user->getId());

        if (!$loadedUser) {
            throw new UserNotFoundException(sprintf('User with ID "%s" not found.', $user->getId()));
        }

        return $loadedUser;
    }

    /**
     * Tells Symfony to use this provider for this User class.
     */
    public function supportsClass(string $class): bool
    {
        return User::class === $class || is_subclass_of($class, User::class);
    }

    /**
     * Upgrades the hashed password of a user, typically for using a better hash algorithm.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        $this->setTenantConnection();
        // TODO: when hashed passwords are in use, this method should:
        // 1. persist the new password in the user storage
        // 2. update the $user object with $user->setPassword($newHashedPassword);

        // Implement password upgrade logic if needed
        $user->setPassword($newHashedPassword);
        $this->userRepository->save($user);
    }


    private function setTenantConnection(): void
    {
        // Access the current request
        $request = $this->requestStack->getCurrentRequest();

        $connection = $this->em->getConnection();

        if (!$connection instanceof MultiDbConnectionWrapper) {
            throw new \RuntimeException('Wrong connection');
        }

        $host = $request->getHost();

        $parts = explode('.', $host);
        $subdomain = $parts[0]; // The first part is the subdomain

        if (count($parts) === 1) {
            throw new \RuntimeException('Wrong connection');
        }

        // Optionally, you may want to handle special cases like 'www'
        if ($subdomain === 'www' && count($parts) > 2) {
            $subdomain = $parts[1]; // Adjust for 'www.example.com' format
        }

        $connection->selectDatabase($subdomain);
    }
}