<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentaireRepository")
 */
class Commentaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="text")
     */
    private $commentaire;

    /**
     * @ORM\Column(type="date")
     */
    private $date_enregistrement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="commentaires")
     */
    private $membre_id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Annonce", cascade={"persist", "remove"})
     */
    private $annonce_id;

    public function getId(): ?int
    {
        return $this->id;
    }
    

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getDateEnregistrement(): ?\DateTimeInterface
    {
        return $this->date_enregistrement;
    }

    public function setDateEnregistrement(\DateTimeInterface $date_enregistrement): self
    {
        $this->date_enregistrement = $date_enregistrement;

        return $this;
    }

    public function getMembreId(): ?User
    {
        return $this->membre_id;
    }

    public function setMembreId(?User $membre_id): self
    {
        $this->membre_id = $membre_id;

        return $this;
    }

    public function getAnnonceId(): ?Annonce
    {
        return $this->annonce_id;
    }

    public function setAnnonceId(?Annonce $annonce_id): self
    {
        $this->annonce_id = $annonce_id;

        return $this;
    }

}
