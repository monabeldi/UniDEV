<?php

namespace App\Entity;

use App\Repository\HotelRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=HotelRepository::class)
 */
class Hotel
{


    /**
     * @ORM\Id
     * @Assert\NotBlank(message="champ obligatoire")
     * @ORM\Column(type="integer")
     */
    private $idhotel;

    /**
     * @Assert\NotBlank(message="champ obligatoire")
     * @ORM\Column(type="string", length=30)
     */
    private $nomhotel;

    /**
     * @Assert\NotBlank(message="champ obligatoire")
     * @ORM\Column(type="string", length=50)
     */
    private $adrrhotel;

    /**
     * @Assert\NotBlank(message="champ obligatoire")
     * @ORM\Column(type="string", length=255)
     */
    private $photohotel;

    /**
     * @Assert\NotBlank(message="champ obligatoire")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ratehotel;

    /**
     * @Assert\NotBlank(message="champ obligatoire")
     * @ORM\Column(type="string", length=100)
     */
    private $deschotel;

    /**
     * @Assert\NotBlank(message="champ obligatoire")
     * @ORM\Column(type="float")
     */
    private $prixnuit;

    /**
     * @Assert\NotBlank(message="champ obligatoire")
     * @ORM\Column(type="integer")
     */
    private $numtelhotel;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $idchambre;



    public function getIdHotel(): ?int
    {
        return $this->idhotel;
    }

    public function setIdHotel(string $idhotel): self
    {
        $this->idhotel = $idhotel;

        return $this;
    }

    public function getNomHotel(): ?string
    {
        return $this->nomhotel;
    }

    public function setNomHotel(string $nomhotel): self
    {
        $this->nomhotel = $nomhotel;

        return $this;
    }

    public function getAdrrHotel(): ?string
    {
        return $this->adrrhotel;
    }

    public function setAdrrHotel(string $adrrhotel): self
    {
        $this->adrrhotel = $adrrhotel;

        return $this;
    }

    public function getPhotoHotel(): ?string
    {
        return $this->photohotel;
    }

    public function setPhotoHotel(string $photohotel): self
    {
        $this->photohotel = $photohotel;

        return $this;
    }

    public function getRateHotel(): ?string
    {
        return $this->ratehotel;
    }

    public function setRateHotel(?string $ratehotel): self
    {
        $this->ratehotel = $ratehotel;

        return $this;
    }

    public function getDescHotel(): ?string
    {
        return $this->deschotel;
    }

    public function setDescHotel(string $deschotel): self
    {
        $this->deschotel = $deschotel;

        return $this;
    }

    public function getPrixNuit(): ?float
    {
        return $this->prixnuit;
    }

    public function setPrixNuit(float $prixnuit): self
    {
        $this->prixnuit = $prixnuit;

        return $this;
    }

    public function getNumTelHotel(): ?int
    {
        return $this->numtelhotel;
    }

    public function setNumTelHotel(int $numtelhotel): self
    {
        $this->numtelhotel = $numtelhotel;

        return $this;
    }

    public function getIdChambre(): ?int
    {
        return $this->idchambre;
    }

    public function setIdChambre(?int $idchambre): self
    {
        $this->idchambre = $idchambre;

        return $this;
    }
}
