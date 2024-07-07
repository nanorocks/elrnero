<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixture extends Fixture
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    
    public function load(ObjectManager $manager): void
    {
        $avatarPath = '600x400.png'; // Replace with actual file path or URL to your avatar

        $categoriesData = [
            [
                'parent_id' => null,
                'name' => 'Development',
                'description' => 'Courses related to software development',
                'avatar' => $avatarPath,
            ],
            [
                'parent_id' => null,
                'name' => 'Design',
                'description' => 'Courses related to graphic design',
                'avatar' => $avatarPath,
            ],
            [
                'parent_id' => null,
                'name' => 'Business',
                'description' => 'Courses related to business and entrepreneurship',
                'avatar' => $avatarPath,
            ],
            [
                'parent_id' => null,
                'name' => 'Marketing',
                'description' => 'Courses related to marketing strategies',
                'avatar' => $avatarPath,
            ],
            [
                'parent_id' => null,
                'name' => 'IT & Software',
                'description' => 'Courses related to IT and software',
                'avatar' => $avatarPath,
            ],
            [
                'parent_id' => null,
                'name' => 'Health & Fitness',
                'description' => 'Courses related to health and fitness',
                'avatar' => $avatarPath,
            ],
            [
                'parent_id' => null,
                'name' => 'Music',
                'description' => 'Courses related to music and audio production',
                'avatar' => $avatarPath,
            ],
            [
                'parent_id' => null,
                'name' => 'Photography',
                'description' => 'Courses related to photography and visual arts',
                'avatar' => $avatarPath,
            ],
            [
                'parent_id' => null,
                'name' => 'Language',
                'description' => 'Courses related to language learning',
                'avatar' => $avatarPath,
            ],
            [
                'parent_id' => null,
                'name' => 'Personal Development',
                'description' => 'Courses related to personal growth and self-improvement',
                'avatar' => $avatarPath,
            ],
            [
                'parent_id' => null,
                'name' => 'Cooking',
                'description' => 'Courses related to cooking and culinary arts',
                'avatar' => $avatarPath,
            ],
            [
                'parent_id' => null,
                'name' => 'Art & Culture',
                'description' => 'Courses related to art history and cultural studies',
                'avatar' => $avatarPath,
            ],
            [
                'parent_id' => null,
                'name' => 'Science',
                'description' => 'Courses related to scientific principles and research',
                'avatar' => $avatarPath,
            ],
            [
                'parent_id' => null,
                'name' => 'Finance & Accounting',
                'description' => 'Courses related to financial management and accounting',
                'avatar' => $avatarPath,
            ],
            [
                'parent_id' => null,
                'name' => 'Environment & Sustainability',
                'description' => 'Courses related to environmental conservation and sustainability',
                'avatar' => $avatarPath,
            ],
            [
                'parent_id' => null,
                'name' => 'History',
                'description' => 'Courses related to historical events and civilizations',
                'avatar' => $avatarPath,
            ],
            [
                'parent_id' => null,
                'name' => 'Sports',
                'description' => 'Courses related to sports and athletics',
                'avatar' => $avatarPath,
            ],
            [
                'parent_id' => null,
                'name' => 'Technology',
                'description' => 'Courses related to emerging technologies and innovations',
                'avatar' => $avatarPath,
            ],
            [
                'parent_id' => null,
                'name' => 'Travel & Adventure',
                'description' => 'Courses related to travel destinations and adventure experiences',
                'avatar' => $avatarPath,
            ],
            [
                'parent_id' => null,
                'name' => 'Education',
                'description' => 'Courses related to educational theories and practices',
                'avatar' => $avatarPath,
            ],
        ];


        foreach ($categoriesData as $data) {
            $category = new Category();
            $category->setParent($data['parent_id']);
            $category->setName($data['name']);
            $category->setDescription($data['description']);
            $category->setAvatar($data['avatar']);

            // Generate slug based on the name
            $slug = $this->slugger->slug($data['name'])->lower();
            $category->setSlug($slug);

            $manager->persist($category);
        }

        $manager->flush();
    }
}