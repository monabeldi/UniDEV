<?php

namespace App\Entity;

use App\Repository\UberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UberRepository::class)
 */
class Uber
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("uber")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="nom is required")
     * @ORM\Column(type="string", length=255)
     * @Groups("uber")
     */
    private $nom_uber;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Please set phone number!")
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a number")
     * @Assert\Length (min="8",
     *     minMessage="number must constaint 8 min")
     * @Groups("uber")
     */
    private $num_tel_uber;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="working field is required")
     * @Groups("uber")
     *
     */
    private $field_uber;

    /**
     *  @ORM\Column(type="float")
     * @Assert\NotBlank(message="set a price please!")
     * @Groups("uber")
     *
     */
    private $prix_uber;



    /**
     * @ORM\OneToOne(targetEntity=Transports::class, mappedBy="uber", cascade={"persist", "remove"})
     * @Groups("uber")
     */
    private $transport;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Please upload image")
     * @Assert\File(mimeTypes={"image/jpeg"})
     * @Groups("uber")
     */
    private $photo_uber;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomUber(): ?string
    {
        return $this->nom_uber;
    }

    public function setNomUber(string $nom_uber): self
    {
        $this->nom_uber = $nom_uber;

        return $this;
    }

    public function getNumTelUber(): ?int
    {
        return $this->num_tel_uber;
    }

    public function setNumTelUber(int $num_tel_uber): self
    {
        $this->num_tel_uber = $num_tel_uber;

        return $this;
    }


    public function getFieldUber(): ?string
    {
        return $this->field_uber;
    }

    public function setFieldUber(string $field_uber): self
    {
        $this->field_uber = $field_uber;

        return $this;
    }

    public function getPrixUber(): ?float
    {
        return $this->prix_uber;
    }

    public function setPrixUber(float $prix_uber): self
    {
        $this->prix_uber = $prix_uber;

        return $this;
    }


    public function getTransport(): ?Transports
    {
        return $this->transport;
    }

    public function setTransport(?Transports $transport): self
    {
        // unset the owning side of the relation if necessary
        if ($transport === null && $this->transport !== null) {
            $this->transport->setUber(null);
        }

        // set the owning side of the relation if necessary
        if ($transport !== null && $transport->getUber() !== $this) {
            $transport->setUber($this);
        }

        $this->transport = $transport;

        return $this;
    }


    public function getPhotoUber(): ?string
    {
        return $this->photo_uber;
    }

    public function setPhotoUber(string $photo_uber): self
    {
        $this->photo_uber = $photo_uber;

        return $this;
    }

}
