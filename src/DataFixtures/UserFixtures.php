<?php

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

// Si une table dépend d'une autre table pour etre rempli, il faut que la fixture implemente l'interface
// Doctrine\Common\DataFixtures\DependentFixtureInterface
class UserFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {

        $this->createMany(5,"admin", function ($num){
           $userAdmin = new User;
           $userAdmin->setNom($this->faker->lastName);
           $userAdmin->setPrenom($this->faker->firstName);
           $civilite = $this->faker->randomElement(["H", "F", "A"]);
           $userAdmin->setCivilite($civilite);
           $userAdmin->setPseudo("admin".$num );
           $userAdmin->setTelephone($this->faker->e164PhoneNumber);
           $date = new \DateTime($this->faker->date($format = 'Y-m-d', $max = 'now'));
           $userAdmin->setDateEnregistrement($date);
           $email = "admin".$num."@annonceo.com";
           $userAdmin->setEmail($email);
           $userAdmin->setPassword(password_hash("admin".$num, PASSWORD_DEFAULT));
           $userAdmin->setRoles(["ROLE_ADMIN"]);
           return $userAdmin;
        });

        $this->createMany(50,"membre", function ($num){

            $user = new User;
            $user->setNom($this->faker->lastName);
            $user->setPrenom($this->faker->firstName);
            $civilite = $this->faker->randomElement(["H", "F", "A"]);
            $user->setCivilite($civilite);
            $user->setPseudo("user".$num );
            $user->setTelephone($this->faker->e164PhoneNumber);
            $date = new \DateTime($this->faker->date($format = 'Y-m-d', $max = 'now'));
            $user->setDateEnregistrement($date);
            $email = "user".$num."@mail.org";
            $user->setEmail($email);
            $user->setPassword(password_hash("user".$num, PASSWORD_DEFAULT));
            $user->setRoles(["ROLE_USER"]);
           return $user;
        });
        $manager->flush();

    }

    public function getDependencies(){
        return [ UserFixtures::class, PhotoFixtures::class, CategorieFixtures::class ];
    }
}
