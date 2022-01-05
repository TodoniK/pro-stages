<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Entreprise;
use App\Entity\Stage;
use App\Entity\Formation;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {

            $entreprise = new Entreprise();

            $stage = new Stage();

            // Mise en place des données générées pour les entreprises
            $entreprise->setActivite($faker->realText(100,2));
            $entreprise->setAdresse($faker->address(100));
            $entreprise->setNom($faker->company(30));
            $entreprise->setURLsite($faker->url(100));

            $idEntreprise = $faker->getId();

            // Mise en place des données pour les stages
            

        
            $manager->persist($entreprise);

        }

       /* for ($i = 0; $i < 10; $i++) {

            $stage = new Stage();
        
            $manager->persist($stage);

        }

        for ($i = 0; $i < 10; $i++) {

            $formation = new Formation();
           
            $manager->persist($formation);

        }*/

        $manager->flush();
    }
}
