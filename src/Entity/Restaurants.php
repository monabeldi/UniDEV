<?php

namespace App\Entity;

use App\Repository\RestaurantsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RestaurantsRepository::class)
 */
class Restaurants
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="nom is required")
     */
    private $nom_rest;

    /**
     * @ORM\Column(type="string", length=255)
     *@Assert\NotBlank(message="adress is required")
     */
    private $add_rest;

    /**
     * @ORM\Column(type="integer",length=8)
     * @Assert\Length(min="8",
     *     minMessage="Number must containt 8 carater",
     *     maxMessage="Number must containt 8 carater")
     */
    private $num_tel_rest;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo_rest;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_cata;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomRest(): ?string
    {
        return $this->nom_rest;
    }

    public function setNomRest(string $nom_rest): self
    {
        $this->nom_rest = $nom_rest;

        return $this;
    }

    public function getAddRest(): ?string
    {
        return $this->add_rest;
    }

    public function setAddRest(string $add_rest): self
    {
        $this->add_rest = $add_rest;

        return $this;
    }

    public function getNumTelRest(): ?int
    {
        return $this->num_tel_rest;
    }

    public function setNumTelRest(int $num_tel_rest): self
    {
        $this->num_tel_rest = $num_tel_rest;

        return $this;
    }

    public function getPhotoRest(): ?string
    {
        return $this->photo_rest;
    }

    public function setPhotoRest(?string $photo_rest): self
    {
        $this->photo_rest = $photo_rest;

        return $this;
    }

    public function getIdCata(): ?int
    {
        return $this->id_cata;
    }

    public function setIdCata(int $id_cata): self
    {
        $this->id_cata = $id_cata;

        return $this;
    }
}
