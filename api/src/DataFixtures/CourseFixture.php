<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Course;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CourseFixture extends Fixture implements DependentFixtureInterface
{

    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $courseNames = [
            'Introduction to Python Programming',
            'Advanced JavaScript Techniques',
            'Data Science with R',
            'Machine Learning Fundamentals',
            'Web Development with HTML5 and CSS3',
            'React.js: From Beginner to Advanced',
            'Building RESTful APIs with Node.js',
            'Mastering SQL Databases',
            'Introduction to Cybersecurity',
            'Mobile App Development with Flutter',
            'Game Development with Unity',
            'Artificial Intelligence Basics',
            'Deep Learning with TensorFlow',
            'Full-Stack Development with MERN',
            'Cloud Computing with AWS',
            'Introduction to Blockchain Technology',
            'Building Microservices with Spring Boot',
            'Data Analysis with Pandas',
            'DevOps with Docker and Kubernetes',
            'UI/UX Design Principles',
            'Project Management with Agile',
            'Introduction to Kotlin for Android Development',
            'Network Programming with Java',
            'Computer Vision with OpenCV',
            'Data Visualization with D3.js',
            'Advanced CSS and Sass',
            'Functional Programming in Scala',
            'Big Data with Hadoop',
            'Responsive Web Design with Bootstrap',
            'Introduction to Natural Language Processing',
            'Java Programming for Beginners',
            'Cryptography and Network Security',
            'Software Testing and Quality Assurance',
            'C++ Programming: From Beginner to Expert',
            'Frontend Development with Angular',
            'Backend Development with Django',
            'Object-Oriented Programming with C#',
            'Digital Marketing Essentials',
            'Internet of Things (IoT) with Arduino',
            'Data Structures and Algorithms in Python',
            'Introduction to PHP and MySQL',
            'Augmented Reality with ARKit',
            'Advanced iOS Development with Swift',
            'Business Intelligence with Power BI',
            'Blockchain Development with Ethereum',
            'Introduction to Quantum Computing',
            'Ethical Hacking and Penetration Testing',
            'Artificial Intelligence for Robotics',
            'Financial Modeling with Excel',
            'Game Design Theory and Practice',
            'Introduction to SAS Programming'
        ];



        $faker = Factory::create();

        for ($i = 0; $i < 50; $i++) {
            $course = new Course();

            $randomKey = array_rand($courseNames);
            $randomCourseName = $courseNames[$randomKey];
            $course->setName($randomCourseName);

            $course->setDescription($faker->name());
            $course->setLastUpdated($faker->dateTimeThisYear());
            $course->setLanguage($faker->randomElement(['English', 'French', 'Spanish', 'German']));
            $course->setTotalHours($faker->numberBetween(1, 100));
            $course->setTotalVideos($faker->numberBetween(1, 50));
            $course->setTotalArticles($faker->numberBetween(1, 20));
            $course->setDownloadableResources($faker->numberBetween(1, 10));
            $course->setMultiPlatformAccess($faker->boolean());
            $course->setHasCertificate($faker->boolean());
            $course->setPrice($faker->numberBetween(50, 1000));
            $course->setPercentageDiscountForPrice($faker->numberBetween(0, 50));
            $course->setVideoThumbnail('th-1-6689c76bdece3.jpg');
            $course->setTotalStudents($faker->numberBetween(0, 1000));
            $course->setTags(['tag1', 'tag2', 'tag3']);
            $course->setLevel($faker->numberBetween(1, 3));
            $course->setPublished($faker->boolean());

            $slug = $this->slugger->slug($course->getName())->lower();
            $course->setSlug($slug);

            // Assign a random user to each course
            $randomUserReference = 'user-' . rand(0, 24);
            $course->setUser($this->getReference($randomUserReference));

            $manager->persist($course);
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