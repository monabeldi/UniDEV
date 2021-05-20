<?php

namespace App\Entity;

use App\Repository\GuidesRepository;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Scalar\String_;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=GuidesRepository::class)
 */
class Guides
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("guide")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="nom is required")
     * @Groups("guide")
     */
    private $nom_gui;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="prenom is required")
     * @Groups("guide")
     *
     */
    private $prenom_gui;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("guide")
     *
     */
    private $etat_gui;


    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("guide")
     */
    private $desc_gui;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="number")
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a number")
     * @Assert\Length (min="8",
     *     minMessage="number must constaint 8 min")
     * @Groups("guide")
     *
     */
    private $num_tel_gui;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please upload image")
     * @Assert\File(mimeTypes={"image/jpeg"})
     * @Groups("guide")
     */
    private $photo_gui;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomGui(): ?string
    {
        return $this->nom_gui;
    }

    public function setNomGui(string $nom_gui): self
    {
        $this->nom_gui = $nom_gui;

        return $this;
    }

    public function getPrenomGui(): ?string
    {
        return $this->prenom_gui;
    }

    public function setPrenomGui(string $prenom_gui): self
    {
        $this->prenom_gui = $prenom_gui;

        return $this;
    }

    public function getEtatGui(): ?string
    {
        return $this->etat_gui;
    }

    public function setEtatGui(string $etat_gui): self
    {
        $this->etat_gui = $etat_gui;

        return $this;
    }


    public function getDescGui(): ?string
    {
        return $this->desc_gui;
    }

    public function setDescGui(string $desc_gui): self
    {
        $this->desc_gui = $desc_gui;

        return $this;
    }

    public function getNumTelGui(): ?int
    {
        return $this->num_tel_gui;
    }

    public function setNumTelGui(int $num_tel_gui): self
    {
        $this->num_tel_gui = $num_tel_gui;

        return $this;
    }

    public function getPhotoGui()
    {
        return $this->photo_gui;
    }

    public function setPhotoGui($photo_gui)
    {
        $this->photo_gui = $photo_gui;

        return $this;
    }
}
