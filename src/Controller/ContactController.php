<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Entity\Contact;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class ContactController extends AbstractController
{


    /**
     * @Route("/contact", name="contact")
     */
    public function ListMsg(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $utilisateur= new utilisateur();
        $usersession=$this->getUser();
        $utilisateur= $this->getDoctrine()->getRepository(Utilisateur::class)
        ->find($usersession->getId());
        
        $result = $em->createQueryBuilder();

        /*-------------------------------List Msg Envoyé-------------------------------*/
        
        $ListMsgEnvoyer = $result->select('C')
            ->from('App\Entity\Contact','C')
            ->where('C.expediteur=:id')
            ->setParameter('id',$usersession->getId())
            ->getQuery()
            ->getResult();
        /*------------------------------List Msg Reçus-----------------------------------*/
            
        $ListMsgReçus = $result->select('Cr')
            ->from('App\Entity\Contact','Cr')
            ->where('Cr.destinataire=:id')
            ->setParameter('id',$usersession->getId())
            ->getQuery()
            ->getResult(); 


        /*-------------------------------Tous les Utilisateurs--------------------------------------*/
        $TousLesUtilisateurs =  $result->select('util')
                    ->from('App\Entity\Utilisateur','util')
                    ->getQuery()
                    ->getResult();     

          
        return $this->render('contact/Contact.html.twig', [
            'ListMsgEnvoyer' =>$ListMsgEnvoyer,
            'ListMsgReçus' => $ListMsgReçus,
            'TousLesUtilisateurs' =>$TousLesUtilisateurs,
            'controller_name' => 'ContactController',
        ]);
    }

    
     /**
     * @Route("/contact/message/{id}/{id2}", name="message.new")
     */

    public function newMessage(Request $request,$id,$id2)
    { 
        dump($id);
        dump($id2);
        /*-------------------------id_destinataire----------------------------*/
        $destinataire= new utilisateur();
        $destinataire= $this->getDoctrine()->getRepository(Utilisateur::class)->find($id);        
        dump($destinataire);
        /*--------------------------------------------------------------------*/


        /*---------------------------id_expediteur-----------------------------*/
        $utilisateur= new utilisateur();
        $usersession=$this->getUser();
        $expediteur= $this->getDoctrine()->getRepository(Utilisateur::class)
        ->find($usersession->getId());
        dump($expediteur);
        /*---------------------------------------------------------------------*/

        $contact = new contact();
        $form =$this->createFormBuilder($contact)
                    ->add('contenu', TextareaType::class, [
                           'attr' => array('cols' => '10', 'rows' => '10','style'=>"resize:none"),
                                ])
                    ->getForm();  

        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
            
        if ($form->isSubmitted() && $form->isValid())
         {
            
            $expediteur->addContact($contact);
            $destinataire->addDest($contact);
            $contact->setDateEnvoi(new \DateTime('now'));
            $em->persist($contact);
            $em->flush();
            return $this->redirectToRoute('search_trajet.show',array('id' => $id2));
  
        }

         return $this->render('popup/ContactModal.html.twig', [
           'form' => $form->createView(),
           'destinataire'=>$destinataire,
           'id2'=>$id2,
           'controller_name' => 'ContactController',
        ]);

    }

   /**
   * @Route("/contact/delete/{id}", name="message.delete",methods="DELETE")
   */

    public function deleteMessage(Contact $msg)
    {
        
        $em=$this->getDoctrine()->getManager();
        $em->remove($msg);
        $em->flush();
        
        return $this->redirectToRoute('contact');
    }



    /**
     * @Route("/contact/RenvoyerMsg/{id}", name="RenvoyerMsg.new")
     */

    public function RenvoyerMsg(Request $request,$id)
    { 
        //dump($id);
        /*-------------------------id_destinataire----------------------------*/
        $destinataire= new utilisateur();
        $destinataire= $this->getDoctrine()->getRepository(Utilisateur::class)->find($id);        
        //dump($destinataire);
        /*--------------------------------------------------------------------*/


        /*---------------------------id_expediteur-----------------------------*/
        $utilisateur= new utilisateur();
        $usersession=$this->getUser();
        $expediteur= $this->getDoctrine()->getRepository(Utilisateur::class)
        ->find($usersession->getId());
        //dump($expediteur);
        /*---------------------------------------------------------------------*/
        $posts = $request->request->all();
        $message = new contact();
       // $contenu= $posts['RepondreMsg'];
        //dump($contenu);
        $em = $this->getDoctrine()->getManager();
        if($request->isMethod('post'))
        {
            $message->setContenu($posts['RepondreMsg']);
            $expediteur->addContact($message);
            $destinataire->addDest($message);
            $message->setDateEnvoi(new \DateTime('now'));

            $em->persist($message);
            $em->flush();
            return $this->redirectToRoute('contact');
        }
       
         return $this->render('contact/Contact.html.twig', [
           'controller_name' => 'ContactController',
        ]);

    }
}
