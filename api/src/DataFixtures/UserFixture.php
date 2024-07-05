<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Create an admin user
        $adminUser = new User();
        $adminUser->setName('Andrej Nankov');
        $adminUser->setEmail('andrejnankov@gmail.com');
        $adminUser->setRoles(['ROLE_ADMIN', 'ROLE_USER']);

        // Hash the default password
        $defaultPassword = 'secret'; // Replace with your default password
        $hashedPassword = $this->passwordHasher->hashPassword($adminUser, $defaultPassword);
        $adminUser->setPassword($hashedPassword);

        $manager->persist($adminUser);
        $manager->flush();
    }
}