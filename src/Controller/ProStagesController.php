<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;


class ProStagesController extends AbstractController
{
    /**
     * @Route("/", name="prostages_accueil")
     */
    public function index(): Response
    {
		// Récupérer les repository de mes entités
		$repositoryStage = $this->getDoctrine()->getRepository(Stage::class);
		
		// Récupérer les ressources enregistrées en BD
		$stages = $repositoryStage->findall();

		// Affichage de la vue et passage des données
        return $this->render('pro_stages/index.html.twig',['stages'=>$stages]);
    }
	
	/**
	* @Route ("/entreprises" , name ="prostages_entreprises")
	*/
	public function filtrerEntreprises () : Response
	{
		// Récupérer les repository de mes entités
		$repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);
		
		// Récupérer les ressources enregistrées en BD
		$entreprises = $repositoryEntreprise->findall();

		// Affichage de la vue et passage des données
		return $this->render('pro_stages/entreprises.html.twig',['entreprises'=>$entreprises]);
	}
	
	/**
	* @Route ("/formations" , name ="prostages_formations")
	*/
	public function filtrerFormations () : Response
	{
		// Récupérer les repository de mes entités
		$repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);
		
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
		return $this->render('pro_stages/stages.html.twig',[
            'idStage' => $id,
        ]);
	 }
}

