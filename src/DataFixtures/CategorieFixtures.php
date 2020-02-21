<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class CategorieFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(11,"categorie", function ($num){

            $cat = new Categorie();
            $cat->setTitre("titre$num");
            $cat->setMotscles("categorie$num");

            return $cat;
        });
        $manager->flush();
    }
}
