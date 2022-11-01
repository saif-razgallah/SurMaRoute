<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfilRepository")
 */
class Profil
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $presentez_vous;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $musique;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fumeur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $animaux;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $discussion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $code_postal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pays;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $marque_voiture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $modele_voiture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $date_circulation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $couleur_voiture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $immatriculation_voiture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $niveau_confort;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $identifiant_facebook;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $identifiant_twitter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $identifiant_instagram;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPresentezVous(): ?string
    {
        return $this->presentez_vous;
    }

    public function setPresentezVous(?string $presentez_vous): self
    {
        $this->presentez_vous = $presentez_vous;

        return $this;
    }

    public function getMusique(): ?string
    {
        return $this->musique;
    }

    public function setMusique(?string $musique): self
    {
        $this->musique = $musique;

        return $this;
    }

    public function getFumeur(): ?string
    {
        return $this->fumeur;
    }

    public function setFumeur(?string $fumeur): self
    {
        $this->fumeur = $fumeur;

        return $this;
    }

    public function getAnimaux(): ?string
    {
        return $this->animaux;
    }

    public function setAnimaux(?string $animaux): self
    {
        $this->animaux = $animaux;

        return $this;
    }

    public function getDiscussion(): ?string
    {
        return $this->discussion;
    }

    public function setDiscussion(?string $discussion): self
    {
        $this->discussion = $discussion;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(?string $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getMarqueVoiture(): ?string
    {
        return $this->marque_voiture;
    }

    public function setMarqueVoiture(?string $marque_voiture): self
    {
        $this->marque_voiture = $marque_voiture;

        return $this;
    }

    public function getModeleVoiture(): ?string
    {
        return $this->modele_voiture;
    }

    public function setModeleVoiture(?string $modele_voiture): self
    {
        $this->modele_voiture = $modele_voiture;

        return $this;
    }

    public function getDateCirculation(): ?string
    {
        return $this->date_circulation;
    }

    public function setDateCirculation(?string $date_circulation): self
    {
        $this->date_circulation = $date_circulation;

        return $this;
    }

    public function getCouleurVoiture(): ?string
    {
        return $this->couleur_voiture;
    }

    public function setCouleurVoiture(?string $couleur_voiture): self
    {
        $this->couleur_voiture = $couleur_voiture;

        return $this;
    }

    public function getImmatriculationVoiture(): ?string
    {
        return $this->immatriculation_voiture;
    }

    public function setImmatriculationVoiture(?string $immatriculation_voiture): self
    {
        $this->immatriculation_voiture = $immatriculation_voiture;

        return $this;
    }

    public function getNiveauConfort(): ?string
    {
        return $this->niveau_confort;
    }

    public function setNiveauConfort(?string $niveau_confort): self
    {
        $this->niveau_confort = $niveau_confort;

        return $this;
    }

    public function getIdentifiantFacebook(): ?string
    {
        return $this->identifiant_facebook;
    }

    public function setIdentifiantFacebook(?string $identifiant_facebook): self
    {
        $this->identifiant_facebook = $identifiant_facebook;

        return $this;
    }

    public function getIdentifiantTwitter(): ?string
    {
        return $this->identifiant_twitter;
    }

    public function setIdentifiantTwitter(?string $identifiant_twitter): self
    {
        $this->identifiant_twitter = $identifiant_twitter;

        return $this;
    }

    public function getIdentifiantInstagram(): ?string
    {
        return $this->identifiant_instagram;
    }

    public function setIdentifiantInstagram(?string $identifiant_instagram): self
    {
        $this->identifiant_instagram = $identifiant_instagram;

        return $this;
    }


     public function __toString()
    {

        return 'null';
    }


}
