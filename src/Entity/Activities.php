<?php

namespace App\Entity;

use App\Repository\ActivitiesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ActivitiesRepository::class)
 */
class Activities
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
    private $nom_activite;

    /**
     * @ORM\Column(type="string", length=255)
     */

    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieu_evenement;

    /**
     * @ORM\Column(type="float")
     */
    private $prix_participation;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan("today UTC")
     */
    private $date_debut;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan("today UTC")
     */

    private $date_fin;

    /**
     * @ORM\Column(type="time")
     */
    private $heure_evenement;

    /**
     * @ORM\Column(type="time")
     */
    private $heure_fin;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Organisateurs::class, inversedBy="activities")
     */
    private $organisateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomActivite(): ?string
    {
        return $this->nom_activite;
    }

    public function setNomActivite(string $nom_activite): self
    {
        $this->nom_activite = $nom_activite;

        return $this;
    }

    public function getLieuEvenement(): ?string
    {
        return $this->lieu_evenement;
    }

    public function setLieuEvenement(string $lieu_evenement): self
    {
        $this->lieu_evenement = $lieu_evenement;

        return $this;
    }

    public function getPrixParticipation(): ?float
    {
        return $this->prix_participation;
    }

    public function setPrixParticipation(float $prix_participation): self
    {
        $this->prix_participation = $prix_participation;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getHeureEvenement(): ?\DateTimeInterface
    {
        return $this->heure_evenement;
    }

    public function setHeureEvenement(\DateTimeInterface $heure_evenement): self
    {
        $this->heure_evenement = $heure_evenement;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heure_fin;
    }

    public function setHeureFin(\DateTimeInterface $heure_fin): self
    {
        $this->heure_fin = $heure_fin;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getOrganisateur(): ?Organisateurs
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?Organisateurs $organisateur): self
    {
        $this->organisateur = $organisateur;

        return $this;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }





}
