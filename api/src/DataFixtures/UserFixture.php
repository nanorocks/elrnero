<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Enum\RoleEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;
use Symfony\Component\Security\Core\Role\Role;

class UserFixture extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $roles = RoleEnum::getAllRoles();
        // Create an admin user
        $adminUser = new User();
        $adminUser->setName('Andrej Nankov');
        $adminUser->setEmail('andrejnankov@gmail.com');
        $adminUser->setRoles(['ROLE_ADMIN']);

        // Hash the default password
        $defaultPassword = 'secret'; // Replace with your default password
        $hashedPassword = $this->passwordHasher->hashPassword($adminUser, $defaultPassword);
        $adminUser->setPassword($hashedPassword);

        $manager->persist($adminUser);

        // Create 50 fake users
        $faker = Factory::create();

        for ($i = 0; $i < 25; $i++) {
            $user = new User();
            $user->setName($faker->name());
            $user->setEmail($faker->unique()->safeEmail());
            $user->setRoles(['ROLE_USER', 'ROLE_CREATOR']);

            $user->setPassword($hashedPassword);

            $manager->persist($user);

            $this->addReference('user-' . $i, $user);
        }

        for ($i = 0; $i < 25; $i++) {
            $user = new User();
            $user->setName($faker->name());
            $user->setEmail($faker->unique()->safeEmail());
            $user->setRoles(['ROLE_USER']);

            $user->setPassword($hashedPassword);

            $manager->persist($user);
        }

        $manager->flush();
    }
}