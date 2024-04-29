<?php

namespace App\Entity;

use App\Repository\ActiviteRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Centre;
use Symfony\Component\Validator\Constraints as Assert;



#[ORM\Entity(repositoryClass: ActiviteRepository::class)]
class Activite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id_activite = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le champ Nom_centre ne doit pas être vide")]
    private ?string $Nom_activite = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le champ Nom_centre ne doit pas être vide")]
    private ?string $Description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le champ Nom_centre ne doit pas être vide")]
    private ?string $type = null;

    #[ORM\ManyToOne(targetEntity: Centre::class)]
    #[ORM\JoinColumn(name: 'id_centre', referencedColumnName: 'id_centre')]
    private ?Centre $centre;
    


    public function getId_activite(): ?int
    {
        return $this->id_activite;
    }

    public function getNomActivite(): ?string
    {
        return $this->Nom_activite;
    }

    public function setNomActivite(string $nom_activite): static
    {
        $this->Nom_activite = $nom_activite;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $description): static
    {
        $this->Description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }


    public function getCentre(): ?Centre
    {
        return $this->centre;
    }

    public function setCentre(?Centre $centre): static
    {
        $this->centre = $centre;

        return $this;
    }

}
