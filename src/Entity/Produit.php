<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{
    /**
     * @ORM\Id
     * @Groups("Produit:read")
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups("Produit:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomProduit;

    /**
     * @Groups("Produit:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $marqueProduit;

    /**
     * @Groups("Produit:read")
     * @ORM\Column(type="float", nullable=true)
     */
    private $prixProduit;

    /**
     * @Groups("Produit:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photoProduit;

    /**
     * @Groups("Produit:read")
     * @ORM\OneToOne(targetEntity=Boutique::class, cascade={"persist", "remove"})
     */
    private $idBoutique;

    /**
     * @Groups("Produit:read")
     * @ORM\ManyToOne(targetEntity=Boutique::class, inversedBy="idBoutique")
     * @ORM\JoinColumn(nullable=false)
     */
    private $boutique;




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProduit(): ?string
    {
        return $this->nomProduit;
    }

    public function setNomProduit(?string $nomProduit): self
    {
        $this->nomProduit = $nomProduit;

        return $this;
    }

    public function getMarqueProduit(): ?string
    {
        return $this->marqueProduit;
    }

    public function setMarqueProduit(?string $marqueProduit): self
    {
        $this->marqueProduit = $marqueProduit;

        return $this;
    }

    public function getPrixProduit(): ?float
    {
        return $this->prixProduit;
    }

    public function setPrixProduit(?float $prixProduit): self
    {
        $this->prixProduit = $prixProduit;

        return $this;
    }

    public function getPhotoProduit(): ?string
    {
        return $this->photoProduit;
    }

    public function setPhotoProduit(?string $photoProduit): self
    {
        $this->photoProduit = $photoProduit;

        return $this;
    }

    public function getIdBoutique(): ?Boutique
    {
        return $this->idBoutique;
    }

    public function setIdBoutique(?Boutique $idBoutique): self
    {
        $this->idBoutique = $idBoutique;

        return $this;
    }

    public function getBoutique(): ?Boutique
    {
        return $this->boutique;
    }

    public function setBoutique(?Boutique $boutique): self
    {
        $this->boutique = $boutique;

        return $this;
    }



}
