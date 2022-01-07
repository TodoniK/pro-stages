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
	
	/**
	 * @Route ("/stages/{id}" , name ="prostages_stages")
	 */
	 public function afficherStages ($id) : Response
	 {

		// Récupérer les repository de mes entités
		$repositoryStage = $this->getDoctrine()->getRepository(Stage::class);
		
		// Récupérer les ressources enregistrées en BD
		$stage = $repositoryStage->find($id);

		// Affichage de la vue et passage des données
		return $this->render('pro_stages/stages.html.twig',['stage' => $stage,]);
		
	 }

	/**
	 * @Route ("/formations/{id}" , name ="prostages_formations_stages")
	 */
	public function afficherStagesParFormations ($id) : Response
	{

	   // Récupérer les repository de mes entités
	   $repositoryStageParFormations = $this->getDoctrine()->getRepository(Formation::class);
	   
	   // Récupérer les ressources enregistrées en BD
	   $stageParFormation = $repositoryStageParFormations->find($id);

	   // Affichage de la vue et passage des données
	   return $this->render('pro_stages/stagesParFormation.html.twig',['stageParFormation' => $stageParFormation,]);
	   
	}

	/**
	 * @Route ("/entreprises/{id}" , name ="prostages_entreprises_stages")
	 */
	public function afficherStagesParEntreprises ($id) : Response
	{

	   // Récupérer les repository de mes entités
	   $repositoryStageParEntreprises = $this->getDoctrine()->getRepository(Entreprise::class);
	   
	   // Récupérer les ressources enregistrées en BD
	   $stageParEntreprise = $repositoryStageParEntreprises->find($id);

	   // Affichage de la vue et passage des données
	   return $this->render('pro_stages/stagesParEntreprise.html.twig',['stageParEntreprise' => $stageParEntreprise,]);
	   
	}
}

