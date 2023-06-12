<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use App\Entity\Programm;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $programm = $manager->getRepository(Programm::class)->findAll();

        for ($a = 0; $a < 10; $a++) {
            $actor = new Actor();
            $actor->setName($faker->lastName());

            // $randomProgramm = $faker->randomElement($programm);
            // $actor->setProgramm($randomProgramm);
            for ($i = 1; $i <= 3; $i++) {

                $actor->addProgramm($this->getReference('program_' . rand(1, 7)));
            }
            //dd($actor);
            $manager->persist($actor);
        }
        $manager->flush();
    }


    public function getDependencies()
    {
        return [
            ProgramFixtures::class
        ];
    }
}
