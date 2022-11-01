<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Entity\Trajet;
use App\Entity\Profil;
use App\Entity\Reservation;
use App\Entity\Commentaire;
use App\Entity\Avis;
use App\Form\TrajetSearchType;
use App\Entity\TrajetSearch;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UtilisateurRepository;
use App\Repository\TrajetRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;




class SearchTrajetController extends AbstractController
{
    /**
     * @Route("/search/trajet", name="search_trajet")
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {

        //Créer une entité qui va représenter notre recherche
        //Créer un formulaire dabs le dossier form 
        //Gérer le traitement dans le controller

        $search= new TrajetSearch();
        $form=$this->createForm(TrajetSearchType::class,$search);
        $form->handleRequest($request);


        $em = $this->getDoctrine()->getManager();
        $result = $em->createQueryBuilder();
        // tous les annonces 
        $trajetsQuery = $result->select('t','u','p')
            ->from('App\Entity\Trajet','t')
            ->leftJoin ('t.utilisateur', 'u')
            ->leftJoin ('u.profil', 'p')
            ->orderBy('t.id', 'DESC')
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);


        dump($trajetsQuery);
        $totalrows =count($trajetsQuery); 
        //dump($totalrows);
        
        if ($search->getVilleDepart() && $search->getVilleArrivee()||$search->getDateDepart() ) 
             {      
                //les annonces avec serach ville depar et ville arrivé
                 $trajetsQuery = $result
                                ->where('t.ville_depart=:ahlem and t.ville_arrivee=:villeArrivee or t.date_depart=:dateDepart')
                                ->setParameter('ahlem', $search->getVilleDepart())
                                ->setParameter('villeArrivee', $search->getVilleArrivee())
                                ->setParameter('dateDepart', $search->getDateDepart())
                                ->getQuery()
                                ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
                           
             }  


        $trajets = $paginator->paginate(
        $trajetsQuery, /* query NOT result */
        $request->query->getInt('page', 1), /*page number*/
        4 /*limit per page*/
          );

        /*------------------------- Afficher la notation Avis de L'utilisateur--------------------------*/

        $result4 = $em->createQueryBuilder();
        $avis_util = $result4->select('avi')
            ->from('App\Entity\Avis','avi')
            ->getQuery()
            ->getResult();
        dump($avis_util);

        return $this->render('search/SearchTrajet.html.twig', [
            'trajets' => $trajets,
            'totalrows'=>$totalrows,
            'avis_util'=>$avis_util,
            'form'    => $form->createView(),            
            'controller_name' => 'SearchTrajetController'
        ]);
    }


    /**
     * @Route("/search/trajet/{id}", name="search_trajet.show")
     * @return Response 
     */

    public function showTrajet(Request $request,$id): Response
    {   

        $em = $this->getDoctrine()->getManager();
        $result = $em->createQueryBuilder();

        $trajetInfo = $result->select('t','u','p')
            ->from('App\Entity\Trajet','t')
            ->leftJoin ('t.utilisateur', 'u')
            ->leftJoin ('u.profil', 'p')
            ->where('t.id=:id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

           // dump($trajetInfo);
        /* Déterminer ID de l'utilisateur d'aprés l'annonce  */
        $id_util = $result
                    ->where('t.id=:id')
                    ->setParameter('id', $id)
                    ->getQuery()
                    ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
                    //dump($id_utilisateur); 
        $id_utilisateur=$id_util[0]['utilisateur']['id'];
            
        //dump($id_utilisateur);

        /* nombre d'annonce publié selon Id utilisateur*/
        $annonce = $result
                    ->where('t.utilisateur=:id')
                    ->setParameter('id', $id_utilisateur)
                    ->getQuery()
                    ->getResult();

        $nbr_annonce=count($annonce);            
       

        /* verifier si une annonce est reserver*/
        $usersession=$this->getUser();

        $annonce_reserve = $result->select('R')
                ->from('App\Entity\Reservation','R')
                ->where('R.trajet=:id and R.statut=:st and R.utilisateur=:ut')
                ->setParameter('id',$id )
                ->setParameter('st','Confirme')
                ->setParameter('ut',$usersession->getId())
                ->getQuery()
                ->getResult();

        $nbr_annonce_reserve=count($annonce_reserve);

        $nbr_place_annonce=$trajetInfo[0]['nbr_place'];
                
        $nbr_place=$nbr_place_annonce-$nbr_annonce_reserve;
        
        /*------------------------------- Laisser un Commentaire  ---------------------------------*/

        /*-------------------------id_trajet----------------------------*/
        $destinataire= new trajet();
        $destinataire= $this->getDoctrine()->getRepository(Trajet::class)->find($id);        
        //dump($destinataire);
        /*--------------------------------------------------------------------*/


        /*---------------------------id_expediteur-----------------------------*/
        $utilisateur= new utilisateur();
        $usersession=$this->getUser();
        $expediteur= $this->getDoctrine()->getRepository(Utilisateur::class)
        ->find($usersession->getId());
       // dump($expediteur);
        /*-------------------------- New Commentaire -----------------------------------------*/
        $Commentaire = new Commentaire();
        $form =$this->createFormBuilder($Commentaire)
                    ->add('contenu', TextareaType::class, [
                           'attr' => array('cols' => '5', 'rows' => '5','style'=>"resize:none"),
                                ])
                    ->getForm();  

        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
            
        if ($form->isSubmitted() && $form->isValid())
         {
            $expediteur->addCommentaire($Commentaire);
            $destinataire->addCommentaire($Commentaire);
            $Commentaire->setDateEnvoi(new \DateTime('Africa/Tunis'));

            $em->persist($Commentaire);
            $em->flush();
            return $this->redirectToRoute('search_trajet.show',array('id' => $id));
  
        }  

        /*------------------------- Affiche Commentaire ----------------------------------------*/
        $Commentaires= new Commentaire();
        $results = $em->createQueryBuilder();

        $Commentaires = $results->select('c','u','t')
            ->from('App\Entity\Commentaire','c')
            ->leftJoin ('c.utilisateur', 'u')
            ->leftJoin ('c.trajet', 't')
            ->where('c.trajet=:id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);       
        //dump($Commentaires);
        /*---------------------------------------------------------------------------------------*/ 

        
        return $this->render('search/ShowTrajet.html.twig', [
            'form' => $form->createView(),
            'nbr_place'=>$nbr_place,
            'nbr_annonce'=>$nbr_annonce,
            'trajetInfos'=>$trajetInfo,
            'Commentaires'=>$Commentaires,
            'controller_name' => 'SearchTrajetController'
            ]);

    }


    /**
     * @Route("/search/trajet/Profil/{id}", name="search_profil.show")
     * @return Response 
     */

    public function showProfil(Request $request,$id): Response
    { 


        $em = $this->getDoctrine()->getManager();
        $result = $em->createQueryBuilder();

        /*-------------- Déterminer le nbr d'annonces selon ID----------------  */

        $trajetInfo = $result->select('t','u','p')
            ->from('App\Entity\Trajet','t')
            ->leftJoin ('t.utilisateur', 'u')
            ->leftJoin ('u.profil', 'p')
            ->where('t.utilisateur=:id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        $nbr_annonce=count($trajetInfo);            
        
        /*------------------------ Les informations de Profil  ----------------- */
        
        $InfoProfil = $result->select('ut','pr')
            ->from('App\Entity\Utilisateur','ut')
            ->leftJoin ('ut.profil', 'pr')
            ->where('ut.id=:id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        dump($InfoProfil);
 
        /*------------------------- Afficher le dernier Avis de L'utilisateur--------------------------*/

        $avis_utilisateur = $result->select('av')
            ->from('App\Entity\Avis','av')
            ->where('av.estNote=:id')
            ->setParameter('id', $id)
            ->setMaxResults(1)
            ->orderBy('av.id', 'DESC')
            ->getQuery()
            ->getResult();
            
        /*---------------------------------------- id_noter  -------------------------------------------*/
        $utilisateur= new utilisateur();
        $usersession=$this->getUser();
        $noter= $this->getDoctrine()->getRepository(Utilisateur::class)
        ->find($usersession->getId());
        //dump($noter);
        /*---------------------------------------------------------------------------------------------*/

        /*----------------------------------------- id-estNote ----------------------------------------*/
        $estNote= new utilisateur();
        $estNote= $this->getDoctrine()->getRepository(Utilisateur::class)->find($id);        
        //dump($estNote);
        /*---------------------------------------------------------------------------------------------*/

        /*------------------------------- Laisser un avis  -------------------------------------------*/
        $avis = new avis();
        $form =$this->createFormBuilder($avis)
                    ->add('avis',ChoiceType::class, [
                                            'choices' => [
                                                'Extraordinaire' => 'Extraordinaire',
                                                'Excellent' => 'Excellent',
                                                'Bien' => 'Bien',
                                                'Décevant' => 'Décevant',
                                                'A éviter' => 'A éviter',]
                                            ])
                    ->add('description', TextareaType::class, [
                           'attr' => array('cols' => '5', 'rows' => '5','style'=>"resize:none"),
                                ])
                    ->getForm();  

        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
            
        if ($form->isSubmitted() && $form->isValid())
         {
            
            $noter->addNoter($avis);
            $estNote->addEstNote($avis);
            $em->persist($avis);
            $em->flush();
            return $this->redirectToRoute('search_profil.show',array('id' => $id));
  
        }  

        /*------------------------- Afficher la notation Avis de L'utilisateur--------------------------*/

        $result2 = $em->createQueryBuilder();
        $avis_util = $result2->select('avi')
            ->from('App\Entity\Avis','avi')
            ->where('avi.estNote=:id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
        dump($avis_util);
        $nbr_avis_util=count($avis_util);

        /*-------------------------------------------------------------------------------*/     
        
        return $this->render('search/ShowProfil.html.twig', [
            'avis_utilisateur'=>$avis_utilisateur,
            'form' => $form->createView(),
            'nbr_annonce'=>$nbr_annonce,
            'InfoProfils'=>$InfoProfil,
            'nbr_avis_util'=>$nbr_avis_util,
            'avis_util'=>$avis_util,
            'controller_name' => 'SearchTrajetController'
            ]);

    }
   

}
