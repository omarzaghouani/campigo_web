<?php

namespace App\Entity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Repository\CentreRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Activite;



#[ORM\Entity(repositoryClass: CentreRepository::class)]
#[UniqueEntity(fields: ['nom_centre'], message: 'There is already an account with this name')]
class Centre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_centre = null;

    #[Assert\NotBlank(message: "Le champ Nom_centre ne doit pas être vide")]
    #[ORM\Column(length: 255)]
    private ?string $nom_centre = null;


    #[Assert\NotBlank(message: "Le champ Ville ne doit pas être vide")]
    #[ORM\Column(length: 255)]
    private ?string $ville = null;


    #[Assert\NotBlank(message: "Le champ Email ne doit pas être vide")]
    #[Assert\Email(message: "Le champ Email doit être une adresse email valide")]
    #[ORM\Column(length: 255)]
    private ?string $mail = null;


    #[Assert\NotBlank(message: "Le champ num_tel ne doit pas être vide")]
    #[Assert\Regex(
        pattern: '/^\d{8}$/',
        message: "Invalide. il doit contenir 8 nombre."
    )]
    #[ORM\Column(length: 255)]
    private ?string $num_tel = null;



    #[Assert\NotBlank(message: "Le champ nbre_activite ne doit pas être vide")]
    #[ORM\Column(length: 255)]
    private ?string $nbre_activite = null;


    #[ORM\Column(length: 255)]
    private ?string $photo = null;


    #[ORM\OneToMany(targetEntity: Activite::class, mappedBy: 'activite')]
    private Collection $Activites;


    public function getId_centre(): ?int
    {
        return $this->id_centre;
    }

    public function getNomCentre(): ?string
    {
        return $this->nom_centre;
    }

    public function setNomCentre(string $nom_centre): static
    {
        $this->nom_centre = $nom_centre;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getNumTel(): ?string
    {
        return $this->num_tel;
    }

    public function setNumTel(string $num_tel): static
    {
        $this->num_tel = $num_tel;

        return $this;
    }

    public function getNbreActivite(): ?string
    {
        return $this->nbre_activite;
    }

    public function setNbreActivite(string $nbre_activite): static
    {
        $this->nbre_activite = $nbre_activite;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

      /**
     * @return Collection<int, Activite>
     */
    public function getActivites(): Collection
    {
        return $this->Activites;
    }

    public function addActivite(Activite $activite): static
    {
        if (!$this->Activites->contains($activite)) {
            $this->Activites->add($activite);
            $activite->setCentre($this);
        }

        return $this;
    }

    public function removeActivite(Activite $activite): static
    {
        if ($this->Activites->removeElement($activite)) {
            // set the owning side to null (unless already changed)
            if ($activite->getCentre() === $this) {
                $activite->setCentre(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getNomCentre(); // Supposons que 'nom' est une propriété de votre entité Livreur
    }
}
