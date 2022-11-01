<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrajetRepository")
 */
class Trajet
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
    private $type_utilisateur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville_depart;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville_arrivee;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_depart;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $heure_depart;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $autoroute;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $frequence;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type_trajet;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $distance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $duree_estimee;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbr_place;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="trajet")
     */
    private $utilisateur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $creer_le;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville_depart_lat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville_depart_lng;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville_arrivee_lat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville_arrivee_lng;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="trajet")
     */
    private $reservations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaire", mappedBy="trajet", orphanRemoval=true)
     */
    private $commentaires;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeUtilisateur(): ?string
    {
        return $this->type_utilisateur;
    }

    public function setTypeUtilisateur(?string $type_utilisateur): self
    {
        $this->type_utilisateur = $type_utilisateur;

        return $this;
    }

     public function getSlug():string
    {
        return (new Slugify())->slugify($this->type_utilisateur);

    }

    public function getVilleDepart(): ?string
    {
        return $this->ville_depart;
    }

    public function setVilleDepart(?string $ville_depart): self
    {
        $this->ville_depart = $ville_depart;

        return $this;
    }

    public function getVilleArrivee(): ?string
    {
        return $this->ville_arrivee;
    }

    public function setVilleArrivee(?string $ville_arrivee): self
    {
        $this->ville_arrivee = $ville_arrivee;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->date_depart;
    }

    public function setDateDepart(?\DateTimeInterface $date_depart): self
    {
        $this->date_depart = $date_depart;

        return $this;
    }

    public function getHeureDepart(): ?\DateTimeInterface
    {
        return $this->heure_depart;
    }

    public function setHeureDepart(?\DateTimeInterface $heure_depart): self
    {
        $this->heure_depart = $heure_depart;

        return $this;
    }

    public function getAutoroute(): ?string
    {
        return $this->autoroute;
    }

    public function setAutoroute(?string $autoroute): self
    {
        $this->autoroute = $autoroute;

        return $this;
    }

    public function getFrequence(): ?string
    {
        return $this->frequence;
    }

    public function setFrequence(?string $frequence): self
    {
        $this->frequence = $frequence;

        return $this;
    }

    public function getTypeTrajet(): ?string
    {
        return $this->type_trajet;
    }

    public function setTypeTrajet(?string $type_trajet): self
    {
        $this->type_trajet = $type_trajet;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDistance(): ?string
    {
        return $this->distance;
    }

    public function setDistance(?string $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getDureeEstimee(): ?string
    {
        return $this->duree_estimee;
    }

    public function setDureeEstimee(?string $duree_estimee): self
    {
        $this->duree_estimee = $duree_estimee;

        return $this;
    }

    public function getNbrPlace(): ?int
    {
        return $this->nbr_place;
    }

    public function setNbrPlace(?int $nbr_place): self
    {
        $this->nbr_place = $nbr_place;

        return $this;
    }


    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }


        public function __toString()
    {

        return $this->type_utilisateur;
    }

        public function getDescription(): ?string
        {
            return $this->description;
        }

        public function setDescription(?string $description): self
        {
            $this->description = $description;

            return $this;
        }

        public function getCreerLe(): ?\DateTimeInterface
        {
            return $this->creer_le;
        }

        public function setCreerLe(\DateTimeInterface $creer_le): self
        {
            $this->creer_le = $creer_le;

            return $this;
        }

        public function getVilleDepartLat(): ?string
        {
            return $this->ville_depart_lat;
        }

        public function setVilleDepartLat(?string $ville_depart_lat): self
        {
            $this->ville_depart_lat = $ville_depart_lat;

            return $this;
        }

        public function getVilleDepartLng(): ?string
        {
            return $this->ville_depart_lng;
        }

        public function setVilleDepartLng(?string $ville_depart_lng): self
        {
            $this->ville_depart_lng = $ville_depart_lng;

            return $this;
        }

        public function getVilleArriveeLat(): ?string
        {
            return $this->ville_arrivee_lat;
        }

        public function setVilleArriveeLat(?string $ville_arrivee_lat): self
        {
            $this->ville_arrivee_lat = $ville_arrivee_lat;

            return $this;
        }

        public function getVilleArriveeLng(): ?string
        {
            return $this->ville_arrivee_lng;
        }

        public function setVilleArriveeLng(?string $ville_arrivee_lng): self
        {
            $this->ville_arrivee_lng = $ville_arrivee_lng;

            return $this;
        }

        /**
         * @return Collection|Reservation[]
         */
        public function getReservations(): Collection
        {
            return $this->reservations;
        }

        public function addReservation(Reservation $reservation): self
        {
            if (!$this->reservations->contains($reservation)) {
                $this->reservations[] = $reservation;
                $reservation->setTrajet($this);
            }

            return $this;
        }

        public function removeReservation(Reservation $reservation): self
        {
            if ($this->reservations->contains($reservation)) {
                $this->reservations->removeElement($reservation);
                // set the owning side to null (unless already changed)
                if ($reservation->getTrajet() === $this) {
                    $reservation->setTrajet(null);
                }
            }

            return $this;
        }

        /**
         * @return Collection|Commentaire[]
         */
        public function getCommentaires(): Collection
        {
            return $this->commentaires;
        }

        public function addCommentaire(Commentaire $commentaire): self
        {
            if (!$this->commentaires->contains($commentaire)) {
                $this->commentaires[] = $commentaire;
                $commentaire->setTrajet($this);
            }

            return $this;
        }

        public function removeCommentaire(Commentaire $commentaire): self
        {
            if ($this->commentaires->contains($commentaire)) {
                $this->commentaires->removeElement($commentaire);
                // set the owning side to null (unless already changed)
                if ($commentaire->getTrajet() === $this) {
                    $commentaire->setTrajet(null);
                }
            }

            return $this;
        }

}
