<?php

namespace App\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;



class LoginListener {

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function onSecurityAuthenticationSuccess(AuthenticationEvent $event)
    {


        $user = $event->getAuthenticationToken()->getUser();

        if ($user instanceof Utilisateur) {
              $user->setDerniereConnexion(new \Datetime("Africa/Tunis"));

              $this->em->persist($user);
              $this->em->flush();
            }


    }
}