<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Note;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

// Si une table dépend d'une autre table pour être rempli, il faut que la fixture implémente l'interface
//  Doctrine\Common\DataFixtures\DependentFixtureInterface
class NoteFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10, "note", function($num){
            $note = (new Note)
                ->setNote($this->faker->numberBetween($min = 1, $max = 5))
                ->setAvis($this->faker->realText(30))
                ->setDateEnregistrement($this->faker->dateTime())
                ->setMembreNoteId($this->getRandomReference("membre"))
                ->setMembreNotantId($this->getRandomReference("membre"));
            return $note;
        });

        $manager->flush();
    }

    public function getDependencies(){
        return [ UserFixtures::class, UserFixtures::class ];
    }

}