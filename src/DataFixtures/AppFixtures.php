<?php

namespace App\DataFixtures;

use App\Entity\DeveloperEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // create 5 developers! Bam!
        for ($i = 1; $i <= 5; $i++) {
            $developer = new DeveloperEntity();
            $developer->setDeveloper('DEV '.$i);
            $developer->setLevel($i);
            $manager->persist($developer);
        }

        $manager->flush();
    }
}
