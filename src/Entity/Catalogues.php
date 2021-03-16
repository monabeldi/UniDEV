<?php

namespace App\Entity;

use App\Repository\CataloguesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CataloguesRepository::class)
 */
class Catalogues
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo_cata;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_plat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $desc_plat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhotoCata(): ?string
    {
        return $this->photo_cata;
    }

    public function setPhotoCata(string $photo_cata): self
    {
        $this->photo_cata = $photo_cata;

        return $this;
    }

    public function getNomPlat(): ?string
    {
        return $this->nom_plat;
    }

    public function setNomPlat(string $nom_plat): self
    {
        $this->nom_plat = $nom_plat;

        return $this;
    }

    public function getDescPlat(): ?string
    {
        return $this->desc_plat;
    }

    public function setDescPlat(string $desc_plat): self
    {
        $this->desc_plat = $desc_plat;

        return $this;
    }
}
