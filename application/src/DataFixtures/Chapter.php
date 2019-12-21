<?php

namespace App\DataFixtures;

use App\Entity\Storage\Database\MySQL\Chapter as Entity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Faker;
use Doctrine\Common\Persistence\ObjectManager;

class Chapter extends Fixture
{
    public function load(ObjectManager $manager)
    {
        self::makeChapters(20, $manager);
    }

    public static function makeChapters(int $numberOfChapters, ObjectManager $manager): ArrayCollection
    {
        $faker = Faker\Factory::create();
        $faker->addProvider(new Faker\Provider\Lorem($faker));
        $chapters = new ArrayCollection();
        for ($i = 0; $i < $numberOfChapters; $i++) {
            $chapter = new Entity();
            $chapter
                ->setTitle($faker->jobTitle)
                ->setBody($faker->text(mt_rand(200, 1000)));
            $manager->persist($chapter);
            $manager->flush();
            $chapters->add($chapter);
        }
        return $chapters;
    }
}
