<?php

namespace App\Entity;

use App\Repository\BoutiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=BoutiqueRepository::class)
 */
class Boutique
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $nomBoutique;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $addressBoutiques;

    /**
     * @ORM\Column(type="integer", length=8 )
     * @Assert\NotBlank
     * @Assert\Length(min="8",
     *
     *     minMessage="Number must containt 8 carater",
     *     maxMessage="Number must containt 8 carater")
     */
    private $numTelBoutique;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
     * @Assert\NotBlank
     */
    private $emailBoutique;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photoBoutique;

    /**
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="boutique")
     */
    private $idBoutique;

    public function __construct()
    {
        $this->idBoutique = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomBoutique(): ?string
    {
        return $this->nomBoutique;
    }

    public function setNomBoutique(?string $nomBoutique): self
    {
        $this->nomBoutique = $nomBoutique;

        return $this;
    }

    public function getAddressBoutiques(): ?string
    {
        return $this->addressBoutiques;
    }

    public function setAddressBoutiques(?string $addressBoutiques): self
    {
        $this->addressBoutiques = $addressBoutiques;

        return $this;
    }

    public function getNumTelBoutique(): ?int
    {
        return $this->numTelBoutique;
    }

    public function setNumTelBoutique(?int $numTelBoutique): self
    {
        $this->numTelBoutique = $numTelBoutique;

        return $this;
    }

    public function getEmailBoutique(): ?string
    {
        return $this->emailBoutique;
    }

    public function setEmailBoutique(?string $emailBoutique): self
    {
        $this->emailBoutique = $emailBoutique;

        return $this;
    }

    public function getPhotoBoutique(): ?string
    {
        return $this->photoBoutique;
    }

    public function setPhotoBoutique(?string $photoBoutique): self
    {
        $this->photoBoutique = $photoBoutique;

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getIdBoutique(): Collection
    {
        return $this->idBoutique;
    }

    public function addIdBoutique(Produit $idBoutique): self
    {
        if (!$this->idBoutique->contains($idBoutique)) {
            $this->idBoutique[] = $idBoutique;
            $idBoutique->setBoutique($this);
        }

        return $this;
    }

    public function removeIdBoutique(Produit $idBoutique): self
    {
        if ($this->idBoutique->removeElement($idBoutique)) {
            // set the owning side to null (unless already changed)
            if ($idBoutique->getBoutique() === $this) {
                $idBoutique->setBoutique(null);
            }
        }

        return $this;
    }
}
