<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProStagesController extends AbstractController
{
    /**
     * @Route("/", name="prostages_accueil")
     */
    public function index(): Response
    {
        return $this->render('pro_stages/index.html.twig');
    }
	
	/**
	* @Route ("/entreprises" , name ="prostages_entreprises")
	*/
	public function filtrerEntreprises () : Response
	{
		return $this->render('pro_stages/entreprises.html.twig');
	}
	
	/**
	* @Route ("/formations" , name ="prostages_formations")
	*/
	public function filtrerFormations () : Response
	{
		return $this->render('pro_stages/formations.html.twig');
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

