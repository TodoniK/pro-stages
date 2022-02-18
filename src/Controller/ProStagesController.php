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
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\EntrepriseType;
use App\Form\StageType;


class ProStagesController extends AbstractController
{

	// Utilisation du système d'injection de dépendances poussé

    /**
     * @Route("/", name="prostages_accueil")
     */
    public function index(StageRepository $repositoryStage): Response
    {
		// Récupérer les ressources enregistrées en BD
		$stages = $repositoryStage->recupererToutLesStagesAvecFormationsEtEntreprises();

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
	 * @Route ("/stages/{idStage}" , name ="prostages_stages")
	 */
	 public function afficherStages (StageRepository $repositoryStages, $idStage) : Response
	 {
		// Affichage de la vue et passage des données
		$stages = $repositoryStages->recupererInformationsStage($idStage);
		
		return $this->render('pro_stages/stages.html.twig', ['stages' => $stages, 'idStage' => $idStage]);

	 }

	/**
	 * @Route ("/formations/{nomCourtFormation}" , name ="prostages_formations_stages")
	 */
	public function afficherStagesParFormations (StageRepository $repositoryStages, $nomCourtFormation) : Response
	{
	   // Affichage de la vue et passage des données
	   $stages = $repositoryStages->trouverStagesFormation($nomCourtFormation);

        return $this->render('pro_stages/stagesParFormation.html.twig', ['stages' => $stages,
                                                                                   'nomFormation' => $nomCourtFormation]);
	   
	}

	/**
	 * @Route ("/entreprises/{nomEntreprise}" , name ="prostages_entreprises_stages")
	 */
	public function afficherStagesParEntreprises (StageRepository $repositoryStages, $nomEntreprise) : Response
	{
	   // Affichage de la vue et passage des données
	   $stages = $repositoryStages->trouverStagesEntreprise($nomEntreprise);

       return $this->render('pro_stages/stagesParEntreprise.html.twig', ['stages' => $stages,'nomEntreprise' => $nomEntreprise]);
	   
	}

	/**
	 * @Route ("/ajouterEntreprise" , name ="prostages_ajout_entreprise")
	 */
	public function ajouterEntreprise (Request $requetteHttp, EntityManagerInterface $manager) : Response
	{

		// Création d'une nouvelle ressource (formulaire)
		$entreprise = new Entreprise();

		// Création du formulaire
		$formulaireEntreprise = $this->createForm(EntrepriseType::class ,$entreprise);
									 

		// Demande d'analyse de la dernière requete http
		$formulaireEntreprise->handleRequest($requetteHttp);

		if ( $formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid())
		{
			// Envoyer les ressources en BD
			$manager->persist($entreprise);
			$manager->flush();

			// Rediriger l'utilisateur vers la page de remerciement
			return $this->redirectToRoute('prostages_remerciement_ajout');
		}
		
		// Création de la vue du formulaire
		$vueFormulaireEntreprise = $formulaireEntreprise -> createView();

	    // Affichage de la vue et du formulaire (passé en paramètre)
        return $this->render('pro_stages/ajouterEntreprise.html.twig', ['vueFormulaireEntreprise' => $vueFormulaireEntreprise]);
	   
	}

	/**
	 * @Route ("/remerciementAjout" , name ="prostages_remerciement_ajout")
	 */
	public function afficherRemerciementAjout () : Response
	{
        return $this->render('pro_stages/remerciementAjout.html.twig');	   
	}

	/**
	 * @Route ("/remerciementModif" , name ="prostages_remerciement_modif")
	 */
	public function afficherRemerciementModif () : Response
	{
        return $this->render('pro_stages/remerciementModif.html.twig');	   
	}

	/**
	* @Route ("/entreprisesAModifier" , name ="prostages_entreprises_a_modifier")
	*/
	public function filtrerEntreprisesAModifier (EntrepriseRepository $repositoryEntreprise) : Response
	{
		// Récupérer les ressources enregistrées en BD
		$entreprises = $repositoryEntreprise->findall();

		// Affichage de la vue et passage des données
		return $this->render('pro_stages/entreprisesAModifier.html.twig',['entreprises'=>$entreprises]);
	}

	/**
	 * @Route ("/modifierEntreprise/{nomEntreprise}" , name ="prostages_entreprises_modifier")
	 */
	public function modifierEntreprise (Request $requetteHttp, EntityManagerInterface $manager, EntrepriseRepository $repositoryEntreprise, $nomEntreprise) : Response
	{
		// Trouver l'entreprise pour pouvoir remplir les champs
		$uneEntreprise = $repositoryEntreprise->trouverEntrepriseParNom($nomEntreprise);

		// Création du formulaire
		$formulaireEntreprise = $formulaireEntreprise = $this->createForm(EntrepriseType::class ,$uneEntreprise);

		// Demande d'analyse de la dernière requete http
		$formulaireEntreprise->handleRequest($requetteHttp);

		if ( $formulaireEntreprise->isSubmitted() )
		{
			// Envoyer les ressources en BD
			$manager->persist($uneEntreprise);
			$manager->flush();

			// Rediriger l'utilisateur vers la page de remerciement
			return $this->redirectToRoute('prostages_remerciement_modif');
		}
		
		// Création de la vue du formulaire
		$vueFormulaireEntreprise = $formulaireEntreprise -> createView();

	    // Affichage de la vue et du formulaire (passé en paramètre)
        return $this->render('pro_stages/modifierEntreprise.html.twig', ['vueFormulaireEntreprise' => $vueFormulaireEntreprise]);
	   
	}

	/**
	 * @Route ("/ajouterStage" , name ="prostages_ajout_stage")
	 */
	public function ajouterStage (Request $requetteHttp, EntityManagerInterface $manager) : Response
	{

		// Création d'une nouvelle ressource (formulaire)
		$stage = new Stage();

		// Création du formulaire
		$formulaireStage = $this->createForm(StageType::class, $stage);
									 

		// Demande d'analyse de la dernière requete http
		$formulaireStage->handleRequest($requetteHttp);

		if ( $formulaireStage->isSubmitted() && $formulaireStage->isValid())
		{
			// Envoyer les ressources en BD
			$manager->persist($stage);
			$manager->persist($stage->getEntreprise());
			$manager->flush();

			// Rediriger l'utilisateur vers la page de remerciement
			return $this->redirectToRoute('prostages_remerciement_ajout');
		}
		
		// Création de la vue du formulaire
		$vueFormulaireStage = $formulaireStage -> createView();

	    // Affichage de la vue et du formulaire (passé en paramètre)
        return $this->render('pro_stages/ajouterStage.html.twig', ['vueFormulaireStage' => $vueFormulaireStage]);
	   
	}
}

