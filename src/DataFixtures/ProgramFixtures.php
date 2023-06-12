<?php

namespace App\DataFixtures;

use App\Entity\Programm;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{

    const PROG = [
        1 => [
            'title' => 'Walking Dead',
            'synopsis' => 'Invasion de Zombies !!',
            'category' => 'Action',
            'year' => 2000,
        ],
        2 => [
            'title' => 'Jujutsu Kaisen',
            'synopsis' => 'Combat d exorcistes',
            'category' => 'Animation',
            'year' => 2020,
        ],
        3 => [
            'title' => 'Titanic',
            'synopsis' => 'Full flemm',
            'category' => 'Fantastique',
            'year' => 1998,
        ],
        4 => [
            'title' => 'Moon Knight',
            'synopsis' => 'Eveil d un dieu Egyptien.',
            'category' => 'Aventure',
            'year' => 2022,
        ],
        5 => [
            'title' => 'World War Z',
            'synopsis' => 'Invasion de Zombies, puissance 8',
            'category' => 'Horreur',
            'year' => 2013,
        ],
        6 => [
            'title' => 'Demon Slayer',
            'synopsis' => 'Je souhiate me venger de Muzan !!',
            'category' => 'Animation',
            'year' => 2019,
        ],
        7 => [
            'title' => 'Arcane',
            'synopsis' => 'Jinx la folle !',
            'category' => 'Animation',
            'year' => 2021,
        ],

    ];


    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager)
    {

        foreach (self::PROG as $key => $values) {

            $program = new Programm();
            $program->setTitle($values['title']);
            $program->setSynopsis($values['synopsis']);
            $program->setYear($values['year']);
            $program->setCategory($this->getReference('category_' . $values['category']));
            $valuesTitle = $values['title'];

            $slug = $this->slugger->slug($program->getTitle());
            $program->setSlug($slug);

            $manager->persist($program);
            $this->addReference('program_' . $key, $program);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
