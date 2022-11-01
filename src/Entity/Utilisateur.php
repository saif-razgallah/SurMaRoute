<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;




/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 * @UniqueEntity(
 * fields={"email"},
 * message="L'email que vous avez indiqué est dejà utilisé !"
 *)
 */
class Utilisateur implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_naissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8",minMessage="Votre mot de passe doit faire minimum 8 caractéres")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password",message="vous n'avez pas tapé le meme mot de passe")
     */
    public $confirm_password;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_inscription;

     /**
     * @Assert\Length(
     *     min = 8,
     *     minMessage = "Password should by at least 8 chars long"
     * )
     */
     protected $oldPassword;

    /**
     * @Assert\Length(
     *     min = 8,
     *     minMessage = "Password should by at least 8 chars long"
     * )
     */
     protected $newPassword;

    // ... //
    protected $captchaCode;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Profil", cascade={"persist", "remove"})
     */
    private $profil;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Trajet", mappedBy="utilisateur")
     */
    private $trajet;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $derniere_connexion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="utilisateur")
     */
    private $reservations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contact", mappedBy="expediteur")
     */
    private $contacts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contact", mappedBy="destinataire")
     */
    private $dest;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Avis", mappedBy="noter")
     */
    private $noter;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Avis", mappedBy="estNote")
     */
    private $estNote;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaire", mappedBy="utilisateur", orphanRemoval=true)
     */
    private $commentaires;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $roles = [];

    public function __construct()
    {
        $this->trajet = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->contacts = new ArrayCollection();
        $this->dest = new ArrayCollection();
        $this->noter = new ArrayCollection();
        $this->estNote = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }

    public function getoldPassword(): ?string
    {
        return $this->oldPassword;
    }

     public function getnewPassword(): ?string
    {
        return $this->newPassword;
    }

     public function setnewPassword($newPassword)
    {

    $this->newPassword=$newPassword;
    }

    public function setoldPassword($oldPassword)
    {

    $this->oldPassword=$oldPassword;
    }
    
    public function getCaptchaCode()
    {
      return $this->captchaCode;
    }

    public function setCaptchaCode($captchaCode)
    {
      $this->captchaCode = $captchaCode;
    }

    // ... //

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(?\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->date_inscription;
    }

    public function setDateInscription(\DateTimeInterface $date_inscription): self
    {
        $this->date_inscription = $date_inscription;

        return $this;
    }
    public function eraseCredentials(){
        
    }

    public function getSalt(){
        return null;
    }

    public function getUsername(): ?string
    {
        return $this->nom;
    }

    public function setUsername(string $nom): self
    {
        $this->username = $nom;

        return $this;
    }





    public function getPlainPassword() 
    {
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getIdProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setIdProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    /**/

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }
 
    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;
 
        return $this;
    }

    /**/


    /**
     * @return Collection|Trajet[]
     */
    public function getTrajet(): Collection
    {
        return $this->trajet;
    }

    public function addTrajet(Trajet $trajet): self
    {
        if (!$this->trajet->contains($trajet)) {
            $this->trajet[] = $trajet;
            $trajet->setUtilisateur($this);
        }

        return $this;
    }

    public function removeTrajet(Trajet $trajet): self
    {
        if ($this->trajet->contains($trajet)) {
            $this->trajet->removeElement($trajet);
            // set the owning side to null (unless already changed)
            if ($trajet->getUtilisateur() === $this) {
                $trajet->setUtilisateur(null);
            }
        }

        return $this;
    }

    public function getDerniereConnexion(): ?\DateTimeInterface
    {
        return $this->derniere_connexion;
    }

    public function setDerniereConnexion(?\DateTimeInterface $derniere_connexion): self
    {
        $this->derniere_connexion = $derniere_connexion;

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
            $reservation->setUtilisateur($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getUtilisateur() === $this) {
                $reservation->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setExpediteur($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->contains($contact)) {
            $this->contacts->removeElement($contact);
            // set the owning side to null (unless already changed)
            if ($contact->getExpediteur() === $this) {
                $contact->setExpediteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Contact[]
     */
    public function getDest(): Collection
    {
        return $this->dest;
    }

    public function addDest(Contact $dest): self
    {
        if (!$this->dest->contains($dest)) {
            $this->dest[] = $dest;
            $dest->setDestinataire($this);
        }

        return $this;
    }

    public function removeDest(Contact $dest): self
    {
        if ($this->dest->contains($dest)) {
            $this->dest->removeElement($dest);
            // set the owning side to null (unless already changed)
            if ($dest->getDestinataire() === $this) {
                $dest->setDestinataire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Avis[]
     */
    public function getNoter(): Collection
    {
        return $this->noter;
    }

    public function addNoter(Avis $noter): self
    {
        if (!$this->noter->contains($noter)) {
            $this->noter[] = $noter;
            $noter->setNoter($this);
        }

        return $this;
    }

    public function removeNoter(Avis $noter): self
    {
        if ($this->noter->contains($noter)) {
            $this->noter->removeElement($noter);
            // set the owning side to null (unless already changed)
            if ($noter->getNoter() === $this) {
                $noter->setNoter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Avis[]
     */
    public function getEstNote(): Collection
    {
        return $this->estNote;
    }

    public function addEstNote(Avis $estNote): self
    {
        if (!$this->estNote->contains($estNote)) {
            $this->estNote[] = $estNote;
            $estNote->setEstNote($this);
        }

        return $this;
    }

    public function removeEstNote(Avis $estNote): self
    {
        if ($this->estNote->contains($estNote)) {
            $this->estNote->removeElement($estNote);
            // set the owning side to null (unless already changed)
            if ($estNote->getEstNote() === $this) {
                $estNote->setEstNote(null);
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
            $commentaire->setUtilisateur($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getUtilisateur() === $this) {
                $commentaire->setUtilisateur(null);
            }
        }

        return $this;
    }

    public function __toString()
    {

        return $this->nom;
    }

    public function setRoles(?array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getRoles():array
    {
        $roles=$this->roles;

        $roles[]='ROLE_USER';

        return array_unique($roles);
    }

    /*
      public function getRoles(){
        
        return ['ROLE_USER'];
    }
    */
 

}
