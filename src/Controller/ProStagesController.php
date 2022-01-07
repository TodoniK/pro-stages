<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Repository\StageRepository;
use App\Repository\FormationRepository;
use App\Repository\EntrepriseRepository;


class ProStagesController extends AbstractController
{

	// Utilisation du système d'injection de dépendances poussé

    /**
     * @Route("/", name="prostages_accueil")
     */
    public function index(StageRepository $repositoryStage): Response
    {
		// Récupérer les ressources enregistrées en BD
		$stages = $repositoryStage->findall();

		// Affichage de la vue et passage des données
        return $this->render('pro_stages/index.html.twig',['stages'=>$stages]);
    }
	
	/**
	* @Route ("/entreprises" , name ="prostages_entreprises")
	*/
	public function filtrerEntreprises (EntrepriseRepository $repositoryEntreprise) : Response
	{
		// Récupérer les ressources enregistrées en BD
		$entreprises = $repositoryEntreprise->findall();

		// Affichage de la vue et passage des données
		return $this->render('pro_stages/entreprises.html.twig',['entreprises'=>$entreprises]);
	}
	
	/**
	* @Route ("/formations" , name ="prostages_formations")
	*/
	public function filtrerFormations (FormationRepository $repositoryFormation) : Response
	{
		// Récupérer les ressources enregistrées en BD
		$formations = $repositoryFormation->findall();

		// Affichage de la vue et passage des données
		return $this->render('pro_stages/formations.html.twig',['formations'=>$formations]);
	}
	

	// Utilisation du système d'injection de dépendances poussé

	/**
	 * @Route ("/stages/{id}" , name ="prostages_stages")
	 */
	 public function afficherStages (Stage $stage) : Response
	 {
		// Affichage de la vue et passage des données
		return $this->render('pro_stages/stages.html.twig',['stage' => $stage]);
		
	 }

	/**
	 * @Route ("/formations/{id}" , name ="prostages_formations_stages")
	 */
	public function afficherStagesParFormations (Formation $stageParFormation) : Response
	{
	   // Affichage de la vue et passage des données
	   return $this->render('pro_stages/stagesParFormation.html.twig',['stageParFormation' => $stageParFormation]);
	   
	}

	/**
	 * @Route ("/entreprises/{id}" , name ="prostages_entreprises_stages")
	 */
	public function afficherStagesParEntreprises (Entreprise $stageParEntreprise) : Response
	{
	   // Affichage de la vue et passage des données
	   return $this->render('pro_stages/stagesParEntreprise.html.twig',['stageParEntreprise' => $stageParEntreprise]);
	   
	}
}

