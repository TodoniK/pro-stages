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
        
        // Création des données aléatoires cohérentes pour stage
        $languages = array("C","C++","Java","Xamarin","Python","Bash","MySQL");
        $métiers = array("Développeur","Concepteur","Analyste","Programmeur","Pentester");
        $objets = array("Développement d'application","Conception de programme","Refonte d'un site web","Programmation d'un OS");

        // Création activité cohérente pour entreprise
        $activites = array("Production de progciels de gestion intégré pour clients privés",
                           "Refonte de sites web pour institution publiques",
                           "Réparation de programmes informatique pour OGN",
                           "Installation de fibre optique dans des zones rurales",
                           "Don d'organes aux hopitaux de France",
                           "Télécommunication pour personnes en situation de handicap",
                           "Gestion comptable à distance pour entreprises publics");

        // Création formations
        $butGim = new Formation();
        $butGim->setNomLong("BUT GÉNIE INDUSTRIEL ET MAINTENANCE");
        $butGim->setNomCourt("BUT GIM");

        $lpEi = new Formation();
        $lpEi->setNomLong("LP ECOLOGIE INDUSTRIELLE");
        $lpEi->setNomCourt("LP EI");

        $butTdc = new Formation();
        $butTdc->setNomLong("BUT TECHNIQUES DE COMMERCIALISATION");
        $butTdc->setNomCourt("BUT TDC");

        $lpCaa = new Formation();
        $lpCaa->setNomLong("LP COMMERCIALISATION AGRODISTRI ET AGROALIMENTAIRE");
        $lpCaa->setNomCourt("LP CAA");

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
        $tableauFormations=array($dutInfo, $dutInfoImagNum, $dutGea, $lpProg, $dutGenieLogiciel,$butGim,$lpEi,$butTdc,$lpCaa);

        // Enregistrement des formations
        foreach($tableauFormations as $formation)
        {
            $manager->persist($formation);
        }


        // Création des entreprises
        for($i=0 ; $i<15 ; $i++)
        {

            $uneActivite = $activites[$faker->numberBetween(0,(count($activites)-1))];

            $entreprise = new Entreprise();
            $entreprise->setActivite($uneActivite);
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
            $entrepriseAssocieAuStage = $faker->numberBetween(0,14);
            $formationAssocieeAuStage = $faker->numberBetween(0,4);

            $unTitre = $métiers[$faker->numberBetween(0,(count($métiers)-1))]." en ".$languages[$faker->numberBetween(0,(count($métiers)-1))];
            $uneDescription = $objets[$faker->numberBetween(0,(count($objets)-1))]." en ".$languages[$faker->numberBetween(0,(count($métiers)-1))]." sur une période de ".$faker->numberBetween(0,12)." mois.";

            $stage = new Stage();
            $stage->setTitre($unTitre);
            $stage->setDescMissions($uneDescription);
            $stage->setEmailContact($faker->email);
            $stage->setEntreprise($entreprises[$entrepriseAssocieAuStage]);
            $stage->addFormation($tableauFormations[$formationAssocieeAuStage]);
            
            $manager->persist($stage);
        }
        
        // Envoi des données enregistrées sur la bd
        $manager->flush();
    }
}
