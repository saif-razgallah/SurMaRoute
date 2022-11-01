<?php

namespace App\Entity;


 class TrajetSearch 
 {
 	/**
 	 * @var string|null
 	 */
 	private $villeDepart;

 	/**
 	 * @var string|null
 	 */
 	private $villeArrivee;

 	/**
 	 * @var datetime|null
 	 */
 	private $dateDepart;


 	public function getVilleDepart(): ?string
    {
        return $this->villeDepart;
    }

    public function setVilleDepart(?string $villeDepart): self
    {
        $this->villeDepart = $villeDepart;

        return $this;
    }

    public function getVilleArrivee(): ?string
    {
        return $this->villeArrivee;
    }

    public function setVilleArrivee(?string $villeArrivee): self
    {
        $this->villeArrivee = $villeArrivee;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->dateDepart;
    }

    public function setDateDepart(?\DateTimeInterface $dateDepart): self
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

 }