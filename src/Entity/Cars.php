<?php

namespace App\Entity;

use App\Repository\CarsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;

/**
 * @ORM\Entity(repositoryClass=CarsRepository::class)
 */
class Cars
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="marque is required")
     * @ORM\Column(type="string", length=255)
     */
    private $marque_car;

    /**
     * @Assert\NotBlank(message="set a price please!")
     * @ORM\Column(type="float")
     */
    private $price_car;

    /**
     * @Assert\NotBlank(message="address is required")
     * @ORM\Column(type="string", length=255)
     */
    private $address_car;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please upload image")
     * @Assert\File(mimeTypes={"image/jpeg"})
     * @ORM\Column(type="string", length=255)
     */
    private $photo_car;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="number")
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a number")
     * @Assert\Length (min="8",
     *     minMessage="number must constaint 8 min")
     */
    private $owner_tel;

    /**
     * @ORM\OneToOne(targetEntity=Transports::class, mappedBy="car", cascade={"persist", "remove"})
     */
    private $transport;

    /**
     * @Assert\NotBlank(message="Please upload image")
     * @Assert\File(mimeTypes={"image/jpeg"})
     */
    private $photos_car = [];



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarqueCar(): ?string
    {
        return $this->marque_car;
    }

    public function setMarqueCar(string $marque_car): self
    {
        $this->marque_car = $marque_car;

        return $this;
    }

    public function getPriceCar(): ?float
    {
        return $this->price_car;
    }

    public function setPriceCar(float $price_car): self
    {
        $this->price_car = $price_car;

        return $this;
    }

    public function getAddressCar(): ?string
    {
        return $this->address_car;
    }

    public function setAddressCar(string $address_car): self
    {
        $this->address_car = $address_car;

        return $this;
    }

    public function getPhotoCar(): ?string
    {
        return $this->photo_car;
    }

    public function setPhotoCar(string $photo_car): self
    {
        $this->photo_car = $photo_car;

        return $this;
    }


    public function getOwnerTel(): ?int
    {
        return $this->owner_tel;
    }

    public function setOwnerTel(int $owner_tel): self
    {
        $this->owner_tel = $owner_tel;

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
            $this->transport->setCar(null);
        }

        // set the owning side of the relation if necessary
        if ($transport !== null && $transport->getCar() !== $this) {
            $transport->setCar($this);
        }

        $this->transport = $transport;

        return $this;
    }
    public function __toString()
    {
        return $this->marque_car;
    }

    public function getPhotosCar(): ?array
    {
        return $this->photos_car;
    }

    public function setPhotosCar(array $photos_car): self
    {
        $this->photos_car = $photos_car;

        return $this;
    }

}
