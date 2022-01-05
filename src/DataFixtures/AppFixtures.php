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

        // Mise en place des données des formations
        
        // Mise en place du tableau associatif de données
        $lesFormations = array(
            "DUT Info" => "DUT Informatique",
            "LP Prog Av." => "License Professionnelle Programmation Avancée",
            "BUT Gim" => "BUT Génie Industriel et Maintenance",
            "BUT Gea" => "BUT Gestion des Entreprises et des Administrations",
            "LP Mn" => "License Professionnelle Métiers du Numérique"
            );

        // Mise en place du tableau de formations (l'objet)
        $toutesFormations = array();

            // Pour chaque donnée, on créer une formation
            foreach($lesFormations as $unNomCourt => $unNomLong)
            {
                $formation=new Formation();
                $formation->setNomLong($unNomLong);
                $formation->setNomCourt($unNomCourt);

                // Et on ajoute l'objet créerau tableau d'objet
                array_push($toutesFormations,$formation);

                //Enregistrement des données à envoyer sur la bd
                $manager->persist($formation);
            }

        for ($i = 0; $i < 10; $i++) {

            $entreprise = new Entreprise();

            // Mise en place des données générées pour les entreprises
            $entreprise->setActivite($faker->realText(100,2));
            $entreprise->setAdresse($faker->address(100));
            $entreprise->setNom($faker->company(30));
            $entreprise->setURLsite($faker->url(100));

            
            for($j=0; $j<4; $j++)
            {

                $stage = new Stage();

                // Mise en place des données pour les stages
                $stage->setEntreprise($entreprise);
                $stage->setTitre($faker->catchPhrase(20));
                $stage->setDescMissions($faker->realText(100,2));
                $stage->setEmailContact($faker->companyEmail(30));
                
                // On choisit une formation aléatoire
                $formationAChoisir = $faker->numberBetween(0,4);
                
                $stage->addFormation($toutesFormations[$formationAChoisir]);

                //Enregistrement des données à envoyer sur la bd
                $manager->persist($stage);

            }

            //Enregistrement des données à envoyer sur la bd
            $manager->persist($entreprise);

        }

        // Envoi des données enregistrées sur la bd
        $manager->flush();
    }
}
