<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UtilisateurRepository;


#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[Assert\NotBlank(message: "Le champ Nom ne doit pas être vide")]
    #[ORM\Column(length: 255)]
    private ? string $nom;

    #[Assert\NotBlank(message: "Le champ prenom ne doit pas être vide")]
    #[ORM\Column(length: 255)]
    private ? string $prenom;

    #[Assert\NotBlank(message: "Le champ Num ne doit pas être vide")]
    #[Assert\Regex(
        pattern: '/^\d{8}$/',
        message: "Invalide. il doit contenir 8 nombre."
    )]
    #[ORM\Column(length: 255)]
    private ? int $numerodetelephone;

    #[Assert\NotBlank(message: "Le champ Email ne doit pas être vide")]
    #[Assert\Email(message: "Le champ Email doit être une adresse email valide")]
    #[ORM\Column(length: 255)]
    private ? string $email;

    #[Assert\NotBlank(message: "Le champ Nom_centre ne doit pas être vide")]
    #[ORM\Column(length: 255)]
    private ? string $motdepasse;

    
    #[Assert\NotBlank(message: "Le champ Nom_centre ne doit pas être vide")]
    #[ORM\Column(length: 255)] 
    private ? string $role = '';

    #[ORM\Column(length: 255)]
    private ? string $photo_d = null;

   
    #[Assert\NotBlank(message: "Le champ actif ne doit pas être vide")]
    #[ORM\Column(length: 255)]
    private bool $actif = false; 


   


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNumerodetelephone(): ?int
    {
        return $this->numerodetelephone;
    }

    public function setNumerodetelephone(int $numerodetelephone): static
    {
        $this->numerodetelephone = $numerodetelephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getMotdepasse(): ?string
    {
        return $this->motdepasse;
    }

    public function setMotdepasse(string $motdepasse): static
    {
        $this->motdepasse = $motdepasse;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getPhotoD(): ?string
    {
        return $this->photo_d;
    }

    public function setPhotoD(string $photo_d): static
    {
        $this->photo_d = $photo_d;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(?bool $actif): static
    {
        $this->actif = $actif;

        return $this;
    }


}
