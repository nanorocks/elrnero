<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Playlist;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PlaylistFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 50; $i++) {
            $playlist = new Playlist();
            $playlist->setName($faker->name());
            $playlist->setCreatedAt($faker->dateTimeThisYear());

            $randomUserReference = 'user-' . rand(0, 24);
            $playlist->setUser($this->getReference($randomUserReference));

            $manager->persist($playlist);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixture::class,
        ];
    }
}