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
        
        // Création formations
        $dutInfo = new Formation();
        $dutInfo->setNomLong("DUT Informatique");
        $dutInfo->setNomCourt("DUT Info");

        $dutInfoImagNum = new Formation();
        $dutInfoImagNum->setNomLong("DUT Informatique et Imagerie Numérique");
        $dutInfoImagNum->setNomCourt("DUT IIM");

        $dutGea = new Formation();
        $dutGea->setNomLong("DUT Gestion des entreprises et des administrations");
        $dutGea->setNomCourt("DUT GEA");

        $lpProg = new Formation();
        $lpProg->setNomLong("Licence programmation");
        $lpProg->setNomCourt("LP");

        $dutGenieLogiciel = new Formation();
        $dutGenieLogiciel->setNomLong("DUT Genie Logiciel");
        $dutGenieLogiciel->setNomCourt("DUT GL");

        // Instanciation du tableau d'objet de formations
        $tableauFormations=array($dutInfo, $dutInfoImagNum, $dutGea, $lpProg, $dutGenieLogiciel);

        // Enregistrement des formations
        foreach($tableauFormations as $formation)
        {
            $manager->persist($formation);
        }


        // Création des entreprises
        for($i=0 ; $i<15 ; $i++)
        {
            $entreprise = new Entreprise();
            $entreprise->setActivite($faker->realText($maxNbChars = 50, $indexSize = 2));
            $entreprise->setAdresse($faker->address);
            $entreprise->setNom($faker->company);
            $entreprise->setURLsite($faker->url);

            // Ajout de l'objet entreprise dans un tableau
            $entreprises[]=$entreprise;
            $manager->persist($entreprise);

        }
    
        // Création des stages
        for($i=0 ; $i<30 ; $i++)
        {
            // Choix d'une entreprise et d'une formation au hasard
            $entrepriseAssocieAuStage = $faker->numberBetween($min=0 , $max=14);
            $formationAssocieeAuStage = $faker->numberBetween($min=0, $max=4);

            $stage = new Stage();
            $stage->setTitre($faker->realText($maxNbChars = 50, $indexSize = 2));
            $stage->setDescMissions($faker->realtext());
            $stage->setEmailContact($faker->email);
            $stage->setEntreprise($entreprises[$entrepriseAssocieAuStage]);
            $stage->addFormation($tableauFormations[$formationAssocieeAuStage]);
            
            $manager->persist($stage);
        }
        
        // Envoi des données enregistrées sur la bd
        $manager->flush();
    }
}
