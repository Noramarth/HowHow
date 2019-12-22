<?php

namespace App\DataFixtures;

use App\lib\Fixtures\Maker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Book extends Fixture
{
    public function load(ObjectManager $manager)
    {
        Maker::make(20, \App\Entity\Storage\Database\MySQL\Book::class, $manager);
    }
}
