<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Annonce;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class AnnonceFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(1,"annonce", function ($num){

            $annonce = new Annonce;
            $annonce->setTitre($this->faker->lastName);
            $annonce->setDescriptionCourte($this->faker->text($maxNbChars = 30) );
            $annonce->setDescriptionLongue($this->faker->text($maxNbChars = 150) );

            $annonce->setPrix($this->faker->numberBetween($min = 10, $max = 100000));
            $annonce->setAdresse($this->faker->streetAddress);

            $date = new \DateTime($this->faker->date($format = 'Y-m-d', $max = 'now'));
            $annonce->setDateEnregistrement($date);
            $annonce->setCp($this->faker->numberBetween($min = 10000, $max = 99999));
            $annonce->setPays($this->faker->country);
            $annonce->setVille("Paris");
            $annonce->setMembreId($this->getRandomReference("membre"));
            $annonce->setPhotoId($this->getRandomReference("photo"));
            $annonce->setCategorieId($this->getRandomReference("categorie"));

            return $annonce;
        });
        $manager->flush();
    }

    public function getDependencies(){
        return [ UserFixtures::class, PhotoFixtures::class, CategorieFixtures::class ];
    }
}
