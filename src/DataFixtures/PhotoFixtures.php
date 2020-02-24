<?php

namespace App\DataFixtures;

use App\Entity\Photo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PhotoFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10,"photo", function ($num){

            $photo = new Photo;
            $photo->setPhoto1($num.".jpg");


            return $photo;
        });
        $manager->flush();
    }
}
