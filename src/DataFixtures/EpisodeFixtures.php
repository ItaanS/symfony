<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Season;
use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{

    // const EPISODES = [
    //     1 => [
    //         'season' => 1,
    //         'title' => 'Test de titre',
    //         'number' => 1,
    //         'sysnopsis' => 'Oh damn'
    //     ],
    //     2 => [
    //         'season' => 1,
    //         'title' => 'Ca fonctionne?!',
    //         'number' => 2,
    //         'sysnopsis' => 'Sérieux !!!!'
    //     ]
    // ];

    // const PROG = [

    //     'Walking Dead',
    //     'Jujutsu Kaisen',
    //     'Titanic',
    //     'Moon Knight',
    //     'World War Z',
    //     'Demon Slayer',
    //     'Arcane'

    // ];

    public function load(ObjectManager $manager): void
    {


        // foreach (self::PROG as $program) {

        //     for ($seasonNumber = 1; $seasonNumber <= 2; $seasonNumber++) {


        //         foreach (self::EPISODES as $episodeData) {

        //             //dump($this);

        //             $episode = new Episode();
        //             $episode->setTitle($episodeData['title']);
        //             $episode->setNumber($episodeData['number']);
        //             $episode->setSynopsis($episodeData['sysnopsis']);
        //             $episode->setSeason($this->getReference($program . '_season_' . $seasonNumber));
        //             $manager->persist($episode);
        //             //$this->addReference('episode_' . $episodeData['number'], $episode);
        //         }
        //         $manager->flush();
        //     }
        // }


        // foreach (self::EPISODE as $keys => $value) {

        //     //dump($this);

        //     $episode = new Episode();
        //     $episode->setTitle($value['title']);
        //     $episode->setNumber($value['number']);
        //     $episode->setSynopsis($value['sysnopsis']);
        //     $episode->setSeason($this->getReference('season_' . $value['season']));
        //     $manager->persist($episode);
        //     $this->addReference('episode_' . $value['number'], $episode);
        // }


        //Puis ici nous demandons à la Factory de nous fournir un Faker
        $faker = Factory::create('fr_FR');

        /**
         * * L'objet $faker que tu récupère est l'outil qui va te permettre 
         * de te générer toutes les données que tu souhaites
         */

         $seasons = $manager->getRepository(Season::class)->findAll();

         for ($j = 0; $j < 9; $j++) {
             $episode = new Episode();
             $episode->setTitle($faker->sentence());
             $episode->setNumber($faker->numberBetween(1, 9));
             $episode->setSynopsis($faker->paragraphs(1, true));
     
             $randomSeason = $faker->randomElement($seasons);
             $episode->setSeason($randomSeason);
     
             $manager->persist($episode);
         }
     
         $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SeasonFixtures::class
        ];
    }
}
