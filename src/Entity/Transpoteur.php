<?php

namespace App\Entity;

use App\Repository\TranspoteurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Transport;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


#[ORM\Entity(repositoryClass: TranspoteurRepository::class)]
class Transpoteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $numCh = null;

    #[Assert\NotBlank(message: "could'nt be nul")]
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[Assert\NotBlank(message: "could'nt be nul")]
    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "could'nt be nul")]
    #[Assert\Regex(
        pattern: '/^\d{8}$/',
        message: "The phone number '{{ value }}' is not a valid phone number. It should contain exactly 8 digits."
    )]
    private ?int $numtel = null;

    #[Assert\Email(message: "mail invalid")]
    #[Assert\NotBlank(message: "could'nt be nul")]
    #[ORM\Column(length: 255)]
    private ?string $email = null;
     
    
    #[ORM\Column(type: "date")]
    private ?\DateTimeInterface $daten = null;

  /************************ */

  #[ORM\OneToMany(targetEntity: Vehicule::class, mappedBy: 'vehicule')]
  private Collection $Vehicule;

   /**
     * @return Collection<int, Vehicule>
     */
    public function getVehicule(): Collection
    {
        return $this->Vehicule;
    }

    public function addVehicule(Vehicule $vehicule): static
    {
        if (!$this->Vehicule->contains($vehicule)) {
            $this->Vehicule->add($vehicule);
            $vehicule->setTranspoteur($this);
        }

        return $this;
    }

    public function removeVehicule(Vehicule $vehicule): static
    {
        if ($this->Vehicule->removeElement($vehicule)) {
            // set the owning side to null (unless already changed)
            if ($vehicule->getTranspoteur() === $this) {
                $vehicule->setTranspoteur(null);
            }
        }

        return $this;
    }

  



/************************* */
    #[ORM\OneToMany(targetEntity: Transport::class, mappedBy: 'transport')]
    private Collection $Transport;
    
  /**
     * @return Collection<int, Transport>
     */
    public function getTransport(): Collection
    {
        return $this->Transport;
    }

    public function addTransport(Transport $transport): static
    {
        if (!$this->Transport->contains($transport)) {
            $this->Transport->add($transport);
            $transport->setTranspoteur($this);
        }

        return $this;
    }

    public function removeTranspoteur(Transport $transport): static
    {
        if ($this->Transport->removeElement($transport)) {
            // set the owning side to null (unless already changed)
            if ($transport->getTranspoteur() === $this) {
                $transport->setTranspoteur(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getNumCh(); // Supposons que 'nom' est une propriété de votre entité Livreur
    }










    public function getNumCh(): ?int
    {
        return $this->numCh;
    }

    public function setNumCh(int $numCh): static
    {
        $this->numCh = $numCh;

        return $this;
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

    public function getNumtel(): ?int
    {
        return $this->numtel;
    }

    public function setNumtel(int $numtel): static
    {
        $this->numtel = $numtel;

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

    public function getDaten(): ?\DateTimeInterface
    {
        return $this->daten;
    }

    public function setDaten(\DateTimeInterface $daten): static
    {
        $this->daten = $daten;

        return $this;
    }

   
}