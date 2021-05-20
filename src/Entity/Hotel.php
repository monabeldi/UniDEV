<?php

namespace App\Entity;

use App\Repository\HotelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=HotelRepository::class)
 */
class Hotel
{




    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @Assert\NotBlank(message="champ obligatoire")
     * @ORM\Column(type="integer")
     * @Groups ("hotel")
     */
    private $idhotel;

    /**
     * @Assert\NotBlank(message="champ obligatoire")
     * @ORM\Column(type="string", length=30)
     * @Groups ("hotel")
     */
    private $nomhotel;

    /**
     * @Assert\NotBlank(message="champ obligatoire")
     * @ORM\Column(type="string", length=50)
     * @Groups ("hotel")
     */
    private $adrrhotel;

    /**
     * @Assert\NotBlank(message="champ obligatoire")
     * @ORM\Column(type="string", length=255)
     * @Groups ("hotel")
     */
    private $photohotel;

    /**
     * @Assert\NotBlank(message="champ obligatoire")
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups ("hotel")
     *
     */
    private $ratehotel;

    /**
     * @Assert\NotBlank(message="champ obligatoire")
     * @ORM\Column(type="string", length=100)
     * @Groups ("hotel")
     */
    private $deschotel;

    /**
     * @Assert\NotBlank(message="champ obligatoire")
     * @ORM\Column(type="float")
     * @Groups ("hotel")
     */
    private $prixnuit;

    /**
     * @Assert\NotBlank(message="champ obligatoire")
     * @ORM\Column(type="integer")
     * @Groups ("hotel")
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

    /**
     * @return Collection|Chambre[]
     */
    public function getChambres(): Collection
    {
        return $this->chambres;
    }

    public function addChambre(Chambre $chambre): self
    {
        if (!$this->chambres->contains($chambre)) {
            $this->chambres[] = $chambre;
            $chambre->setHotel($this);
        }

        return $this;
    }

    public function removeChambre(Chambre $chambre): self
    {
        if ($this->chambres->removeElement($chambre)) {
            // set the owning side to null (unless already changed)
            if ($chambre->getHotel() === $this) {
                $chambre->setHotel(null);
            }
        }

        return $this;
    }
}
