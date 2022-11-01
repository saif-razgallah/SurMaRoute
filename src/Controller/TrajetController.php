<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Entity\Trajet;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\TrajetType;
use App\Repository\UtilisateurRepository;

class TrajetController extends AbstractController
{
    
    /**
     * @Route("/trajet", name="gestion_trajet")
     */
    public function listTrajets(Request $request)
    {
    	$trajets= new trajet();
		$usersession=$this->getUser();

		$repository= $this->getDoctrine()->getRepository(Trajet::class);
        $trajets = $repository->findBy( array('utilisateur' => $usersession->getId()),array('id' => 'DESC'));
        dump($trajets);
        return $this->render('trajet/ListeTrajets.html.twig',compact('trajets'));
    }


    /**
     * @Route("/trajet/new", name="trajet.new")
     */
	public function NewTrajet(Request $request)
	{	
		$trajet= new trajet();
		$utilisateur= new utilisateur();
		$usersession=$this->getUser();
		$utilisateur= $this->getDoctrine()->getRepository(Utilisateur::class)
		->find($usersession->getId());
		
		$posts = $request->request->all();

		if($request->isMethod('post'))
		{
			$trajet->setTypeUtilisateur($posts['type_trajet']);
			$trajet->setVilleDepart($posts['ChmpAdresseDepart']);
			$trajet->setVilleArrivee($posts['ChmpAdresseArrivee']);
			$trajet->setDateDepart(\DateTime::createFromFormat('d-m-Y', $posts['depart_le']));
			$trajet->setHeureDepart(\DateTime::createFromFormat('H:i', $posts['heure-aller']));
			$trajet->setAutoroute($posts['Autoroute']);
			$trajet->setFrequence($posts['frequence']);
			$trajet->setTypeTrajet($posts['mon-trajet']);
			$trajet->setPrix($posts['price_road']);
			$trajet->setDistance($posts['distances']);
			$trajet->setDureeEstimee($posts['duree']);
			$trajet->setDescription($posts['commentaire']);
			$trajet->setNbrPlace($posts['nb_places_conducteur']);
			$trajet->setCreerLe(new \DateTime('now'));
			
			$trajet->setVilleDepartLat($posts['v1lat']);
			$trajet->setVilleDepartLng($posts['v1lng']);
			$trajet->setVilleArriveeLat($posts['v2lat']);
			$trajet->setVilleArriveeLng($posts['v2lng']);
		    

			$em=$this->getDoctrine()->getManager();
			$utilisateur->addTrajet($trajet);
			$em->persist($utilisateur);
			$em->persist($trajet);

			$em->flush();
		}

     return $this->render('trajet/NewTrajet.html.twig');
		
	}

	/**
     * @Route("/trajet/edit/{id}", name="trajet.edit",methods="GET|POST")
     */
	public function editTrajet(Trajet $trajet ,Request $request)
	{			
		$posts = $request->request->all();

		if($request->isMethod('post'))
		{
			$trajet->setTypeUtilisateur($posts['type_trajet']);
			$trajet->setVilleDepart($posts['ChmpAdresseDepart']);
			$trajet->setVilleArrivee($posts['ChmpAdresseArrivee']);
			$trajet->setDateDepart(\DateTime::createFromFormat('d-m-Y', $posts['depart_le']));
			$trajet->setHeureDepart(\DateTime::createFromFormat('H:i', $posts['heure-aller']));
			$trajet->setAutoroute($posts['Autoroute']);
			$trajet->setFrequence($posts['frequence']);
			$trajet->setTypeTrajet($posts['mon-trajet']);
			$trajet->setPrix($posts['price_road']);
			$trajet->setDistance($posts['distances']);
			$trajet->setDureeEstimee($posts['duree']);
			$trajet->setDescription($posts['commentaire']);
			$trajet->setNbrPlace($posts['nb_places_conducteur']);

			$em=$this->getDoctrine()->getManager();
			$em->flush();
			return $this->redirectToRoute('gestion_trajet');
		}	
		
		return $this->render('trajet/EditTrajet.html.twig',[
			'trajet'=>$trajet,
		]);
		
	}

	/**
     * @Route("/trajet/delete/{id}", name="trajet.delete",methods="DELETE")
     */

	// on a différenciée entre les 2 methodes pour ne pas confondre
	public function delete(Trajet $trajet)
	{
		$em=$this->getDoctrine()->getManager();
		$em->remove($trajet);
		$em->flush();
		$this->addFlash('success','Bien supprimé avec succés');
		//return new Response('supprission');
		
       	return $this->redirectToRoute('gestion_trajet');
	}

}
