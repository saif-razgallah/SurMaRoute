<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Entity\Trajet;
use App\Entity\Reservation;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\TrajetType;
use App\Repository\UtilisateurRepository;

class CovoiturageController extends AbstractController
{
   
    /**
     * @Route("/covoiturage", name="covoiturage")
     */
    public function GestionCovoiturage(Request $request)
    {
    	
		$usersession=$this->getUser();
        $em = $this->getDoctrine()->getManager();
        $result = $em->createQueryBuilder();
        
        $time1 = date("H:i");
		$newtimestamp = strtotime('+ 60 minute',strtotime($time1));
		
		$hour  =date('H:i', $newtimestamp);
		$today = date("Y-m-d");
		//dump($today);
		//dump($hour);

        /* ---------------------Annonces-------------------------------- */

         $annonces = $result->select('t','u')
            ->from('App\Entity\Trajet','t')
            ->leftJoin ('t.utilisateur', 'u')
            ->where('t.utilisateur=:id')
		    ->andWhere('(t.date_depart = :dd and t.heure_depart > :hour)or(t.date_depart > :dd)')
            ->setParameter('id', $usersession->getId())
            ->setParameter('dd',$today)
            ->setParameter('hour',$hour)
            ->getQuery()
            ->getResult();

        //dump($annonces);
            
        $historique_annonces = $result
                    ->where('t.utilisateur=:id')
		       		->andWhere('(t.date_depart = :dd and t.heure_depart < :hour)or(t.date_depart < :dd)')
		            ->setParameter('id', $usersession->getId())
		            ->setParameter('dd',$today)
		            ->setParameter('hour',$hour)
                    ->getQuery()
                    ->getResult();

        //dump($historique_annonces);
        
        /* --------------------Reservation------------------------------------*/
        $result2 = $em->createQueryBuilder();
        
        $reservations =  $result2->select('R','T')
		            ->from('App\Entity\Reservation','R')
		            ->leftJoin ('R.trajet', 'T')
		            ->where('R.utilisateur=:ut')
		       		->andWhere('(T.date_depart = :dd and T.heure_depart > :hour)or(T.date_depart > :dd)')
		            ->setParameter('ut',$usersession->getId())
		            ->setParameter('dd',$today)
		            ->setParameter('hour',$hour)
		            ->getQuery()
		            ->getResult();

        dump($reservations) ;   
        
        $historique_reservations = $result2
		            ->where('R.utilisateur=:ut')
		       		->andWhere('(T.date_depart = :dd and T.heure_depart < :hour)or(T.date_depart < :dd)')
		            ->setParameter('ut',$usersession->getId())
		            ->setParameter('dd',$today)
		            ->setParameter('hour',$hour)
                    ->getQuery()
                    ->getResult();

        
        
        //dump($historique_reservations);
        //dump(strtotime($today2) > strtotime("2020-06-07 06:18:05"));

        /*-------------------------------- Tous Les Réservations ----------------------------------*/
        $result3 = $em->createQueryBuilder();
        $TousLesReservations =  $result3->select('re','ut')
		            ->from('App\Entity\Reservation','re')
		            ->leftJoin ('re.utilisateur', 'ut')
		            ->getQuery()
		            ->getResult();
		dump($TousLesReservations);
		/*-------------------------------Tous les Utilisateurs--------------------------------------*/
		$result4 = $em->createQueryBuilder();
        $TousLesUtilisateurs =  $result4->select('util')
		            ->from('App\Entity\Utilisateur','util')
		            ->getQuery()
		            ->getResult(); 

		//dump($TousLesUtilisateurs);                      
   
        return $this->render('covoiturage/Covoiturages.html.twig',[
        	'annonces'=>$annonces,
        	'reservations'=>$reservations,
        	'historique_annonces'=>$historique_annonces,
        	'historique_reservations'=>$historique_reservations,
        	'TousLesReservations'=>$TousLesReservations,
        	'TousLesUtilisateurs'=>$TousLesUtilisateurs,
        	]);
    }



    /**
     * @Route("/covoiturage/accepte/{id}", name="covoiturage.accepter")
     */

	public function accepterAnnonce($id)
	{
		
		$em=$this->getDoctrine()->getManager();
		$repository= $this->getDoctrine()->getRepository(Reservation::class);
		$AnnonceAcceptee = $repository->find($id);
		
		dump($AnnonceAcceptee);
		
		$AnnonceAcceptee->setStatut('Confirme');
		$em->persist($AnnonceAcceptee);
		
		$em->flush();
       	return $this->redirectToRoute('covoiturage');
	}


	/**
     * @Route("/covoiturage/refus/{id}", name="covoiturage.refuser")
     */

	public function refuserAnnonce($id)
	{
		
		$em=$this->getDoctrine()->getManager();
		$repository= $this->getDoctrine()->getRepository(Reservation::class);
		$AnnonceRefus = $repository->find($id);
		
		dump($AnnonceRefus);
		
		$AnnonceRefus->setStatut('Refuse');
		$em->persist($AnnonceRefus);
		
		$em->flush();
       	return $this->redirectToRoute('covoiturage');
	}

	/**
   * @Route("/covoiturage/delete/{id}", name="covoiturage.delete",methods="DELETE")
   */

	public function deleteAnnonce(Trajet $annonce)
	{
		
       	$em=$this->getDoctrine()->getManager();
		$em->remove($annonce);
		$em->flush();
		
       	return $this->redirectToRoute('covoiturage');
	}

	/**
   * @Route("/covoiturage/annuler/{id}", name="covoiturage.annuler",methods="DELETE")
   */

	public function annulerReservation(Reservation $reservation)
	{
		
       	$em=$this->getDoctrine()->getManager();
		$em->remove($reservation);
		$em->flush();
		
       	return $this->redirectToRoute('covoiturage');
	}


	/**
     * @Route("/covoiturage/reserver/{id}", name="reserver.show")
     * @return Response 
     */

    public function reserverTrajet($id): Response
    { 
        //$trajet= new trajet();
        $em = $this->getDoctrine()->getManager();
        $utilisateur= new utilisateur();
        $usersession=$this->getUser();
        $utilisateur= $this->getDoctrine()->getRepository(Utilisateur::class)
        ->find($usersession->getId());

       // dump($utilisateur->getId());
        
        $trajetInfos= new trajet();
        $repository= $this->getDoctrine()->getRepository(Trajet::class);
        $trajetInfo = $repository->find($id);
       // dump($trajetInfo->getUtilisateur()->getId());die;
        /**/
        $result = $em->createQueryBuilder();

        $verif = $result->select('R')
            ->from('App\Entity\Reservation','R')
            ->where('R.trajet=:id and R.utilisateur=:ut')
            ->setParameter('id',$id )
            ->setParameter('ut',$usersession->getId())
            ->getQuery()
            ->getResult();

        /* interdire de réserver l'annonce si l'utilisateur est le propritaire */

        if($trajetInfo->getUtilisateur()->getId() == $utilisateur->getId() )
        {
            
            return $this->render('popup/PopupRappel.html.twig', [
            'controller_name' => 'SearchTrajetController'
            ]);

        }
        /* la fct verif permet de vérifier si l'utilisateur a  réservé l'annonce consulté */
        if (empty($verif))
        {
            $reservation = new reservation();

            $reservation->setStatut('En Attente');
            $reservation->setUtilisateur($utilisateur);
            $reservation->setTrajet($trajetInfo);
            dump($reservation);
            $utilisateur->addReservation($reservation);
              $em->persist($reservation);
              $em->persist($utilisateur);
            $em->flush();
        
        
        return $this->render('popup/PopupSucess.html.twig', [
           
            'controller_name' => 'SearchTrajetController'
            ]);
        }
        else {
            return $this->render('popup/PopupEchec.html.twig', [
           
            'controller_name' => 'SearchTrajetController'
            ]);
        }

    }


}
