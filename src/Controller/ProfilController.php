<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Entity\Profil;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\RegistrationType;
use App\Form\ProfilType;
use App\Form\ResetPasswordType;
use App\Form\UtilisateurType;

use App\Repository\UtilisateurRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;





class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function index()
    {
        return $this->render('profil.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }



    /**
     * @Route("/profil/util", name="profil_util.edit",methods="GET|POST")
     */
    public function editUser(Request $request)
	{	
		$utilisateur= new utilisateur();
		$usersession=$this->getUser();
		
		$utilisateur= $this->getDoctrine()->getRepository(Utilisateur::class)
		->find($usersession->getId());
	        
		//dump($utilisateur);
		//pour exceuter la methode post
		$form=$this->createForm(UtilisateurType::class,$utilisateur);
		
		$form->handleRequest($request);
		$em=$this->getDoctrine()->getManager();
		/**/
		//$file=$utilisateur->getPhoto();
		//dump($file);
		
    	/**/		
		if ($form ->isSubmitted() && $form ->isValid())
			{	
				/** @var UploadedFile $uploadedFile */
			$uploadedFile=$form['imageFile']->getData();
			//dump($uploadedFile);
			if($uploadedFile)
			{
			$destination = $this->getParameter('upload_directory');
            $originalFilename=pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename =$originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
            $uploadedFile->move($destination,$newFilename);
            
            $file = './uploads/'.$utilisateur->getPhoto();
				
				//dump($utilisateur->getPhoto());
				//dump(file_exists($file)); 

				if(file_exists($file)&&($utilisateur->getPhoto())) {
		            unlink($file);
		       	 }     
           
            $utilisateur->setPhoto($newFilename);

         	}
				$em->flush();
				$this->addFlash('success','Bien modifié avec succés');
       			//return $this->redirectToRoute('profil_util.edit');

			}

			$img =$utilisateur->getPhoto();

		return $this->render('profil/UpdatePersonal.html.twig',[
			'utilisateur'=>$utilisateur,
			'img'=>$img,
			'form'=>$form->createView()
		]);
	}

	/**
     * @Route("/profil/password", name="profil_util.password",methods="GET|POST")
     */
	public function editpassword(Request $request,UserPasswordEncoderInterface $encoder)

    {
    	$em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
    	$form = $this->createForm(ResetPasswordType::class,$user);
    	$form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

		     $old_pwd = $user->getoldPassword();
       		 $new_pwd = $user->getnewPassword();
		        dump($old_pwd);   
		        dump($new_pwd);

		    if ($encoder->isPasswordValid($user, $old_pwd)){
		    	 dump($new_pwd);
		    	 $newEncodedPassword = $encoder->encodePassword($user,$new_pwd);
		    	 
		    	 $user->setPassword($newEncodedPassword);
		    	 $em->persist($user);
                 $em->flush();
                 $this->addFlash('success', 'Votre mot de passe à bien été changé !');

		    }else {
            $form->addError(new FormError('Ancien mot de passe incorrect'));
        }

        }
    	return $this->render('profil/ResetPassword.html.twig', array(
    		'form' => $form->createView(),
    	));
    }


    /**
     * @Route("/profil/ReseauSocial", name="profil_ReseauSocial",methods="GET|POST")
     */
	public function editReseauSocial(Request $request)

    {
    	$profil= new profil();
    	$utilisateur= new utilisateur();
		$usersession=$this->getUser();
		
		$utilisateur= $this->getDoctrine()->getRepository(Utilisateur::class)
		->find($usersession->getId());
		
		if (empty($utilisateur->getIdProfil()))
		    {
		       	$utilisateur->setIdProfil($profil);
		       	//dump($utilisateur);

		    }

		    else
		    {
		       //	dump($utilisateur->getIdProfil());
		       	$profil= $this->getDoctrine()->getRepository(Profil::class)
				->find($utilisateur->getIdProfil());
		    }
		    			  dump($profil->getIdentifiantInstagram());

		//pour exceuter la methode post
		$form =$this->createFormBuilder($profil)
					->add('identifiant_facebook')
		            ->add('identifiant_twitter')
		            ->add('identifiant_instagram')
		            ->getForm();		
		$form->handleRequest($request);
		$em=$this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
		        
		        $em->persist($utilisateur);
		        $em->persist($profil);
		        $em->flush();
		        $this->addFlash('success','Bien modifié avec succés');

        }
        dump($profil);

    	return $this->render('profil/ReseauSocial.html.twig', array(
    		'profil'=>$profil,
    		'form' => $form->createView(),
    	));
    }


	/**
     * @Route("/profil/PresentezVous", name="profil_PresentezVous",methods="GET|POST")
     */
	public function editPresentezVous(Request $request)

    {
    	$profile= new profil();
    	$utilisateur= new utilisateur();
		$usersession=$this->getUser();
		
		$utilisateur= $this->getDoctrine()->getRepository(Utilisateur::class)
		->find($usersession->getId());
		
		if (empty($utilisateur->getIdProfil()))
		    {
		       	$utilisateur->setIdProfil($profile);
		    }
		    else
		    {
		      // dump($utilisateur->getIdProfil());
		       	$profile= $this->getDoctrine()->getRepository(Profil::class)
				->find($utilisateur->getIdProfil());
		    }
		  dump($profile->getIdentifiantInstagram());
		  dump($profile);//die();

    	$form =$this->createFormBuilder($profile)
					->add('presentez_vous',TextareaType::class)
		            ->getForm();
		$form->handleRequest($request);
		$em=$this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
		        
		        $em->persist($utilisateur);
		        $em->persist($profile);
		        $em->flush();
		        $this->addFlash('success','Bien modifié avec succés');

        }
                dump($profile);


    	return $this->render('profil/UpdatePresentezVous.html.twig', array(
    		'profil'=>$profile,
    		'form' => $form->createView(),
    	));
    }



    /**
     * @Route("/profil/Car", name="profil_UpdateCar",methods="GET|POST")
     */
	public function editCar(Request $request)

    {
    	$profil= new profil();
    	$utilisateur= new utilisateur();
		$usersession=$this->getUser();
		
		$utilisateur= $this->getDoctrine()->getRepository(Utilisateur::class)
		->find($usersession->getId());
		
		if (empty($utilisateur->getIdProfil()))
		    {
		       	$utilisateur->setIdProfil($profil);
		    }
		    else
		    {
		      // dump($utilisateur->getIdProfil());
		       	$profil= $this->getDoctrine()->getRepository(Profil::class)
				->find($utilisateur->getIdProfil());
		    }
		  dump($profil->getIdentifiantInstagram());
		  dump($profil);//die();

    	$form =$this->createFormBuilder($profil)
    				->add('marque_voiture')
		            ->add('modele_voiture')
		            ->add('date_circulation')
		            ->add('couleur_voiture')
		            ->add('immatriculation_voiture')
		            ->add('niveau_confort',ChoiceType::class, [
							                'choices' => [
							                	'-- Niveau de confort --' => null,
							                	'Véhicule normal       ★'=>'Véhicule normal',
							                    'Véhicule confortable  ★★' => 'Véhicule confortable',
							                    'Véhicule luxueux      ★★★' => 'Véhicule luxueux',]
							                ])
		            ->getForm();
		$form->handleRequest($request);
		$em=$this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
		        
		        $em->persist($utilisateur);
		        $em->persist($profil);
		        $em->flush();
		        $this->addFlash('success','Bien modifié avec succés');

        }
                dump($profil);
    	return $this->render('profil/UpdateCar.html.twig', array(
    		'profil'=>$profil,
    		'form' => $form->createView(),
    	));
    }


    /**
     * @Route("/profil/AdressePostal", name="profil_AdressePostal",methods="GET|POST")
     */
	public function editAdressePostal(Request $request)

    {
    	$profil= new profil();
    	$utilisateur= new utilisateur();
		$usersession=$this->getUser();
		
		$utilisateur= $this->getDoctrine()->getRepository(Utilisateur::class)
		->find($usersession->getId());
		
		if (empty($utilisateur->getIdProfil()))
		    {
		       	$utilisateur->setIdProfil($profil);
		    }
		    else
		    {
		      // dump($utilisateur->getIdProfil());
		       	$profil= $this->getDoctrine()->getRepository(Profil::class)
				->find($utilisateur->getIdProfil());
		    }
		  dump($profil->getIdentifiantInstagram());
		  dump($profil);//die();

    	$form =$this->createFormBuilder($profil)
		    		->add('adresse')
		            ->add('code_postal')
		            ->add('ville')
		            ->add('pays')
		            ->getForm();
		$form->handleRequest($request);
		$em=$this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
		        
		        $em->persist($utilisateur);
		        $em->persist($profil);
		        $em->flush();
		        $this->addFlash('success','Bien modifié avec succés');

        }
                dump($profil);
    	return $this->render('profil/AdressePostal.html.twig', array(
    		'profil'=>$profil,
    		'form' => $form->createView(),
    	));
    }


    /**
     * @Route("/profil/UpdatePreferences", name="profil_UpdatePreferences",methods="GET|POST")
     */
	public function editPreferences(Request $request)

    {
    	$profil= new profil();
    	$utilisateur= new utilisateur();
		$usersession=$this->getUser();
		
		$utilisateur= $this->getDoctrine()->getRepository(Utilisateur::class)
		->find($usersession->getId());
		
		if (empty($utilisateur->getIdProfil()))
		    {
		       	$utilisateur->setIdProfil($profil);
		    }
		    else
		    {
		      // dump($utilisateur->getIdProfil());
		       	$profil= $this->getDoctrine()->getRepository(Profil::class)
				->find($utilisateur->getIdProfil());
		    }
		  dump($profil->getIdentifiantInstagram());
		  dump($profil);//die();

    	$form =$this->createFormBuilder($profil)
		    		->add('musique',ChoiceType::class,array(
					                'choices'  => array(
					                    'Je préfère rouler sans fond sonore' => '0',
					                    'J’écoute la radio ou de la musique' => '1',
					                    
					                ),
					                'expanded' => true,
					                'multiple' => false
					            ))
		            ->add('fumeur',ChoiceType::class,array(
					                'choices'  => array(
					                    'Je fume' => '1',
					                    'Je ne fume pas' => '0',
					                ),
					                'expanded' => true,
					                'multiple' => false
					            ))
		            ->add('animaux',ChoiceType::class,array(
					                'choices'  => array(
					                    "j'accueille un animal de compagnie en voiture" => "1",
					                    "je n'accueille pas un animal en voiture" => "0",
					                    
					                ),
					                'expanded' => true,
					                'multiple' => false
					            ))
		            ->add('discussion',ChoiceType::class,array(
					                'choices'  => array(
					                    'Je ne suis pas bavard' => '0',
					                    'Je discute' => '1',
					                ),
					                'expanded' => true,
					                'multiple' => false
					            ))
		            ->getForm();
		$form->handleRequest($request);
		$em=$this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
		        
		        $em->persist($utilisateur);
		        $em->persist($profil);
		        $em->flush();
		        $this->addFlash('success','Bien modifié avec succés');

        }
                dump($profil);
    	return $this->render('profil/UpdatePreferences.html.twig', array(
    		'profil'=>$profil,
    		'form' => $form->createView(),
    	));
    }

}
