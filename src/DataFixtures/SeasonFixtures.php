<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Season;
use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
// use App\Entity\Programm;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    // const SEASON = [
    //     1 => [
    //         'number' => 1,
    //         'year' => 2000,
    //         'description' => 'Le début de la marche ..',
    //         'program' => 'Walking Dead'
    //     ],
    //     2 => [
    //         'number' => 2,
    //         'year' => 2003,
    //         'description' => 'Zombies contre-atak!',
    //         'program' => 'Walking Dead'
    //     ],
    //     3 => [
    //         'number' => 1,
    //         'year' => 2022,
    //         'description' => 'La mort de Gojo ...',
    //         'program' => 'Jujutsu Kaisen'
    //     ],
    //     4 => [
    //         'number' => 2,
    //         'year' => 2023,
    //         'description' => 'La mort de Gojo ... suite',
    //         'program' => 'Jujutsu Kaisen'
    //     ],
    //     5 => [
    //         'number' => 1,
    //         'year' => 1999,
    //         'description' => 'La mort de ',
    //         'program' => 'Titanic'
    //     ],
    //     6 => [
    //         'number' => 2,
    //         'year' => 2020,
    //         'description' => 'La mort de Gojo ... suite',
    //         'program' => 'Titanic'
    //     ],
    //     7 => [
    //         'number' => 1,
    //         'year' => 2021,
    //         'description' => 'Ok ... suite',
    //         'program' => 'Moon Knight'
    //     ],
    //     8 => [
    //         'number' => 2,
    //         'year' => 2023,
    //         'description' => 'La mort de Gojo ... suite',
    //         'program' => 'Moon Knight'
    //     ],
    //     9 => [
    //         'number' => 1,
    //         'year' => 2013,
    //         'description' => 'La war',
    //         'program' => 'World War Z'
    //     ],
    //     10 => [
    //         'number' => 2,
    //         'year' => 2023,
    //         'description' => 'La war suite',
    //         'program' => 'World War Z'
    //     ],
    //     11 => [
    //         'number' => 1,
    //         'year' => 2019,
    //         'description' => 'La mort de Gojo ... suite',
    //         'program' => 'Demon Slayer'
    //     ],
    //     12 => [
    //         'number' => 2,
    //         'year' => 2023,
    //         'description' => 'La mort de Gojo ... suite',
    //         'program' => 'Demon Slayer'
    //     ],
    //     13 => [
    //         'number' => 1,
    //         'year' => 2021,
    //         'description' => 'La . suite',
    //         'program' => 'Arcane'
    //     ],
    //     14 => [
    //         'number' => 2,
    //         'year' => 2023,
    //         'description' => '.. suite',
    //         'program' => 'Arcane'
    //     ]

    // ];

    public function load(ObjectManager $manager): void
    {

        // // $season = new Season();
        // // $season->setNumber(1);
        // // $season->setProgramm($this->getReference('program_Arcane'));
        // // //... set other season's properties
        // // $this->addReference('season1_Arcane', $season);
        // foreach (self::SEASON as $key => $value) {

        //     $season = new Season();
        //     $season->setNumber($value['number']);
        //     $season->setYear($value['year']);
        //     $season->setDescription($value['description']);
        //     $season->setProgramm($this->getReference('program_' . $value['program']));
        //     $manager->persist($season);
        //     $this->addReference($season->getProgramm()->getTitle() . '_season_' . $value['number'], $season);
        // }

        //Puis ici nous demandons à la Factory de nous fournir un Faker
        $faker = Factory::create('fr_FR');

        /**
         * * L'objet $faker que tu récupère est l'outil qui va te permettre 
         * de te générer toutes les données que tu souhaites
         */

        for ($i = 0; $i < 10; $i++) {
            $season = new Season();
            //Ce Faker va nous permettre d'alimenter l'instance de Season que l'on souhaite ajouter en base
            $season->setNumber($faker->numberBetween(1, 7));
            $season->setYear($faker->year);
            $season->setDescription($faker->paragraphs(1, true));


            $season->setProgramm($this->getReference('program_' . $faker->numberBetween(1, 7)));

            $manager->persist($season);
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
