<?php

namespace App\DataFixtures;

use App\Entity\Home;
use App\Service\Sluggy;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Faker;

class HomeFixtures extends Fixture
{
    private $sluggy;

    public function __construct(Sluggy $sluggy)
    {
        $this->sluggy = $sluggy;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

       for($i=0;$i<=10;$i++)
       {
           $home = new Home();
           $home->setName($faker->name);
           $home->setSlug($this->sluggy->slug($home->getName()));
           $manager->persist($home);
       }

        $manager->flush();
    }
}
