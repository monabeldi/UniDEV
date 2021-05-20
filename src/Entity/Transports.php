<?php

namespace App\Entity;

use App\Repository\TransportsRepository;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=TransportsRepository::class)
 */
class Transports
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
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat_transport;

    /**
     * @ORM\OneToOne(targetEntity=Uber::class, inversedBy="transport", cascade={"persist", "remove"})
     */
    private $uber;

    /**
     * @ORM\OneToOne(targetEntity=Cars::class, inversedBy="Transport", cascade={"persist", "remove"})
     */
    private $car;
    /**
     * * @ORM\Column(type="integer", length=255)
     */
    private $user_id;




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getEtatTransport(): ?string
    {
        return $this->etat_transport;
    }

    public function setEtatTransport(string $etat_transport): self
    {
        $this->etat_transport = $etat_transport;

        return $this;
    }

    public function getUber(): ?Uber
    {
        return $this->uber;
    }

    public function setUber(?Uber $uber): self
    {
        $this->uber = $uber;

        return $this;
    }

    public function getCar(): ?Cars
    {
        return $this->car;
    }

    public function setCar(?Cars $car): self
    {
        $this->car = $car;

        return $this;
    }


    public function __toString()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }
}