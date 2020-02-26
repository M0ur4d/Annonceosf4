<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhotoRepository")
 */
class Photo
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
    private $photo1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo5;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhoto1()
    {
        return $this->photo1;
    }

    public function setPhoto1($photo1): self
    {
        $this->photo1 = $photo1;

        return $this;
    }

    public function getPhoto2()
    {
        return $this->photo2;
    }

    public function setPhoto2($photo2): self
    {
        $this->photo2 = $photo2;

        return $this;
    }

    public function getPhoto3()
    {
        return $this->photo3;
    }

    public function setPhoto3($photo3): self
    {
        $this->photo3 = $photo3;

        return $this;
    }

    public function getPhoto4()
    {
        return $this->photo4;
    }

    public function setPhoto4($photo4): self
    {
        $this->photo4 = $photo4;

        return $this;
    }

    public function getPhoto5()
    {
        return $this->photo5;
    }

    public function setPhoto5($photo5): self
    {
        $this->photo5 = $photo5;

        return $this;
    }
}
