<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Entity\Trajet;
use App\Entity\Commentaire;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment", name="comment")
     */
    public function index()
    {

    	 $em = $this->getDoctrine()->getManager();
        $utilisateur= new utilisateur();
        $usersession=$this->getUser();
        $utilisateur= $this->getDoctrine()->getRepository(Utilisateur::class)
        ->find($usersession->getId());
        
        $result = $em->createQueryBuilder();

        /*-------------------------------List Cmt Envoyé-------------------------------*/
        
        $ListCmtPublie = $result->select('C')
            ->from('App\Entity\Commentaire','C')
            ->where('C.utilisateur=:id')
            ->setParameter('id',$usersession->getId())
            ->getQuery()
            ->getResult();
        dump($ListCmtPublie);    
        /*------------------------------List Cmt Reçus-----------------------------------*/
            
        $ListCmtReçu = $result->select('Cr','Tr')
            ->from('App\Entity\Commentaire','Cr')
            ->leftJoin ('Cr.trajet', 'Tr')
            ->where('Cr.utilisateur!=:id ')
            ->andWhere('Tr.utilisateur=:id')
            ->setParameter('id',$usersession->getId())
            ->getQuery()
            ->getResult(); 
        dump($ListCmtReçu);    
             
          
        return $this->render('comment/Commentaire.html.twig', [
        	'ListCmtPublies'=>$ListCmtPublie,
        	'ListCmtReçus'=>$ListCmtReçu,
            'controller_name' => 'CommentController',
        ]);
    }


    /**
   * @Route("/comment/delete/{id}", name="comment.delete",methods="DELETE")
   */

    public function deleteComment(Commentaire $cmt)
    {
        
        $em=$this->getDoctrine()->getManager();
        $em->remove($cmt);
        $em->flush();
        
        return $this->redirectToRoute('comment');
    }



}
