<?php

namespace App\DataFixtures;

use App\Entity\Commentaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentaireFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(2,"commentaire", function ($num){

            $com = new Commentaire;

            $avis = $this->faker->randomElement(["Bon vendeur", "pas satisfait", "RAS", "tres satisfait, Merci"]);
            $com->setCommentaire($avis);

            $date = new \DateTime($this->faker->date($format = 'Y-m-d', $max = 'now'));
            $com->setDateEnregistrement($date);

            $com->setAnnonceId($this->getRandomReference("annonce"));
            $com->setMembreId($this->getRandomReference("membre") );

            return $com;
        });
        $manager->flush();
    }

    public function getDependencies(){
        return [ UserFixtures::class, AnnonceFixtures::class];
    }

}
