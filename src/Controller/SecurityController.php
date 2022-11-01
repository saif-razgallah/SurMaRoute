<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Entity\Profil;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;





class SecurityController extends AbstractController
{

	/**
	 * @Route("/inscription",name="security_registration")
	 */
    public function registration(Request $request,UserPasswordEncoderInterface $encoder)
    {

        $profil= new profil();
    	$utilisateur= new utilisateur();
    	$utilisateur->setDateInscription(new \Datetime());

    	$form=$this->createForm(RegistrationType::class,$utilisateur);

    	//pour excuter la méthode POST
    	$form->handleRequest($request);
		$em=$this->getDoctrine()->getManager();
		if ($form ->isSubmitted() && $form ->isValid() )
			{	//dump($utilisateur);
				$hash=$encoder->encodePassword($utilisateur,$utilisateur->getPassword());
				$utilisateur->setPassword($hash);
                $utilisateur->setIdProfil($profil);
				$em->persist($utilisateur);
                $em->persist($profil);
				$em->flush();
       			return $this->redirectToRoute('home');
       		}	

    	return $this->render('security/registration.html.twig',[
    		'utilisateur'=>$utilisateur,
    		'form'=>$form->createView()
    	]);

    }

    /**
     * @Route("/connexion",name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils){

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

    	return $this->render('security/login.html.twig', array(
        'last_username' => $lastUsername,
        'error'         => $error
            ));

    }

    /**
     * @Route("/deconnexion",name="security_logout")
     */

    public function logout(){

    }
}
