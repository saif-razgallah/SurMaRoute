<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TrajetSearchType;
use App\Entity\TrajetSearch;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request)
    {


        $search= new TrajetSearch();
        $form=$this->createForm(TrajetSearchType::class,$search);
        $form->handleRequest($request);


        return $this->render('home/home.html.twig', [
            'form'    => $form->createView(),            
            'controller_name' => 'HomeController'
        ]);
    }
}


