<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        //if ($this->getUser()) {
        //     return $this->redirectToRoute('app_login');
        //}

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
	 * @Route ("/ajouterUtilisateur" , name ="prostages_ajout_utilisateur")
	 */
	public function ajouterUtilisateur (Request $requetteHttp, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder) : Response
	{

		// Création d'une nouvelle ressource (formulaire)
		$utilisateur = new User();

		// Création du formulaire
		$formulaireUtilisateur = $this->createForm(UserType::class,$utilisateur);
									 

		// Demande d'analyse de la dernière requete http
		$formulaireUtilisateur->handleRequest($requetteHttp);

		if ( $formulaireUtilisateur->isSubmitted() && $formulaireUtilisateur->isValid())
		{
            // Mettre un role à un utilisateur
            $utilisateur->setRoles(['ROLE_USER']);

			// Encode le mot de passe de l'utilisateur
            $encodageMdp = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());

            $utilisateur->setPassword($encodageMdp);

            // Envoyer les ressources en BD
			$manager->persist($utilisateur);
			$manager->flush();

			// Rediriger l'utilisateur vers la page de remerciement
			return $this->redirectToRoute('prostages_remerciement_ajout');
		}

        // Création de la vue du formulaire
		$vueFormulaireUtilisateur = $formulaireUtilisateur -> createView();

	    // Affichage de la vue et du formulaire (passé en paramètre)
        return $this->render('pro_stages/ajouterUtilisateur.html.twig', ['vueFormulaireUtilisateur' => $vueFormulaireUtilisateur]);
    }
}