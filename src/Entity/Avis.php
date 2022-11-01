<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AvisRepository")
 */
class Avis
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
    private $avis;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="noter")
     */
    private $noter;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="estNote")
     */
    private $estNote;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAvis(): ?string
    {
        return $this->avis;
    }

    public function setAvis(?string $avis): self
    {
        $this->avis = $avis;

        return $this;
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

    public function getNoter(): ?Utilisateur
    {
        return $this->noter;
    }

    public function setNoter(?Utilisateur $noter): self
    {
        $this->noter = $noter;

        return $this;
    }

    public function getEstNote(): ?Utilisateur
    {
        return $this->estNote;
    }

    public function setEstNote(?Utilisateur $estNote): self
    {
        $this->estNote = $estNote;

        return $this;
    }

     public function __toString()
    {

        return $this->avis;
    }
}
