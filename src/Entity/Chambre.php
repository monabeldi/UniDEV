<?php

namespace App\Entity;

use App\Repository\ChambreRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ChambreRepository::class)
 */
class Chambre
{

    /**
     * @Assert\NotBlank(message="champ obligatoire")
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $idchambre;

    /**
     * @Assert\NotBlank(message="champ obligatoire")
     * @ORM\Column(type="string", length=30)
     */
    private $numchambre;

    /**
     * @Assert\NotBlank(message="champ obligatoire")
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $typchambre;

    /**
     * @Assert\NotBlank(message="champ obligatoire")
     * @ORM\Column(type="string", length=30)
     */
    private $etatchambre;

    /**
     * @Assert\NotBlank(message="champ obligatoire")
     * @ORM\Column(type="float")
     */
    private $prixchambre;





    public function getIdChambre(): ?int
    {
        return $this->idchambre;
    }

    public function setIdChambre(int $idchambre): self
    {
        $this->idchambre = $idchambre;

        return $this;
    }

    public function getNumChambre(): ?string
    {
        return $this->numchambre;
    }

    public function setNumChambre(string $numchambre): self
    {
        $this->numchambre = $numchambre;

        return $this;
    }

    public function getTypChambre(): ?string
    {
        return $this->typchambre;
    }

    public function setTypChambre(?string $typchambre): self
    {
        $this->typchambre = $typchambre;

        return $this;
    }

    public function getEtatChambre(): ?string
    {
        return $this->etatchambre;
    }

    public function setEtatChambre(string $etatchambre): self
    {
        $this->etatchambre = $etatchambre;

        return $this;
    }

    public function getPrixChambre(): ?float
    {
        return $this->prixchambre;
    }

    public function setPrixChambre(float $prixchambre): self
    {
        $this->prixchambre = $prixchambre;

        return $this;
    }


}
