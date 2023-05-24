<?php

namespace App\DataFixtures;

use App\Entity\Programm;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $program = new Programm();
        $program->setTitle('Walking Dead');
        $program->setSynopsis('Invasion de Zombies !!');
        $program->setCategory($this->getReference('category_Action'));
        $manager->persist($program);

        $program = new Programm();
        $program->setTitle('Jujutsu Kaisen');
        $program->setSynopsis('Combat d exorcistes');
        $program->setCategory($this->getReference('category_Animation'));
        $manager->persist($program);

        $program = new Programm();
        $program->setTitle('Titanic');
        $program->setSynopsis('Full flemme');
        $program->setCategory($this->getReference('category_Fantastique'));
        $manager->persist($program);

        $program = new Programm();
        $program->setTitle('Moon Knight');
        $program->setSynopsis('Eveil d un dieu Egyptien.');
        $program->setCategory($this->getReference('category_Aventure'));
        $manager->persist($program);

        $program = new Programm();
        $program->setTitle('World War Z');
        $program->setSynopsis('Invasion de Zombies, puissance 8');
        $program->setCategory($this->getReference('category_Horreur'));
        $manager->persist($program);

        $program = new Programm();
        $program->setTitle('Demon Slayer');
        $program->setSynopsis('Je souhiate me venger de Muzan !!');
        $program->setCategory($this->getReference('category_Animation'));
        $manager->persist($program);

        $manager->flush();
    }

    public function getDependencies()
    {
        return[
            CategoryFixtures::class,
        ];
    }
}
