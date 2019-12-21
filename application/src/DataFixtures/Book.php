<?php

namespace App\DataFixtures;

use App\lib\RandomGenerator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class Book extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        $faker->addProvider(new Faker\Provider\Lorem($faker));
        for ($i = 0; $i < 20; $i++) {
            $newBook = new \App\Entity\Storage\Database\MySQL\Book();
            $newBook->setTitle($faker->jobTitle);
            $newBook->setBody($faker->text());
            $hasChapters = $this->shouldHaveChapters();
            $chapters = $hasChapters ? Chapter::makeChapters(RandomGenerator::generateInt(1, 20), $manager) : null;
            $newBook->setChapters($chapters);
            $manager->persist($newBook);
        }
        $manager->flush();
    }

    private function shouldHaveChapters(): bool
    {
        return RandomGenerator::generateBool();
    }
}
