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

    /**
     * @ORM\OneToOne(targetEntity=Restaurants::class, mappedBy="catalogue", cascade={"persist", "remove"})
     */
    private $restaurants;



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

    public function getRestaurants(): ?Restaurants
    {
        return $this->restaurants;
    }

    public function setRestaurants(?Restaurants $restaurants): self
    {
        // unset the owning side of the relation if necessary
        if ($restaurants === null && $this->restaurants !== null) {
            $this->restaurants->setCatalogue(null);
        }

        // set the owning side of the relation if necessary
        if ($restaurants !== null && $restaurants->getCatalogue() !== $this) {
            $restaurants->setCatalogue($this);
        }

        $this->restaurants = $restaurants;

        return $this;
    }


    public function __toString()
    {
        // TODO: Implement __toString() method.
        return (string)$this->getId();
    }


}
