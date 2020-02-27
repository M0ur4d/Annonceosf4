<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NoteRepository")
 */
class Note
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $note;

    /**
     * @ORM\Column(type="text")
     */
    private $avis;


    /**
     * @ORM\Column(type="date")
     */
    private $date_enregistrement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="NoteRecue")
     * @ORM\JoinColumn(nullable=false)
     */
    private $membre_note;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="NoteDonnee")
     * @ORM\JoinColumn(nullable=false)
     */
    private $membre_notant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getAvis(): ?string
    {
        return $this->avis;
    }

    public function setAvis(string $avis): self
    {
        $this->avis = $avis;

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

    public function getMembreNote(): ?User
    {
        return $this->membre_note;
    }

    public function setMembreNote(?User $membre_note): self
    {
        $this->membre_note = $membre_note;

        return $this;
    }

    public function getMembreNotant(): ?User
    {
        return $this->membre_notant;
    }

    public function setMembreNotant(?User $membre_notant): self
    {
        $this->membre_notant = $membre_notant;

        return $this;
    }
}
