<?php

namespace App\Entity\Sandbox;

use App\Repository\Sandbox\FilmRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'sb_films')]
#[ORM\Entity(repositoryClass: FilmRepository::class)]
class Film
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $titre = null;

    #[ORM\Column(options: ['comment' => 'année de sortie'])]
    // le paramètre "name" n'est pas précisé, le nom du champ sera celui du membre : "annee"
    // le paramètre "type" n'est pas précisé, ce sera celui correspondant à 'int' : "integer"
    private ?int $annee = null;

    #[ORM\Column(name: 'enstock', type: 'boolean', options: ['default' => true])]
    // paramètre "name" inutile ici car c'est déjà la valeur par défaut (c'est pour l'exemple)
    // idem pour le paramètre "type"
    private ?bool $enstock = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantite = null;

    /**
     * Film constructor
     */
    public function __construct()
    {
        $this->enstock = true;
        $this->quantite = null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): static
    {
        $this->annee = $annee;

        return $this;
    }

    public function isEnstock(): ?bool
    {
        return $this->enstock;
    }

    public function setEnstock(bool $enstock): static
    {
        $this->enstock = $enstock;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(?int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }
}
