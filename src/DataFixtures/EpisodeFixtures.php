<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Season;
use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{

    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {

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
             
             $slug = $this->slugger->slug($episode->getTitle());
             $episode->setSlug($slug);
     
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
