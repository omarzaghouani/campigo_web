<?php

namespace App\Entity;

use App\Repository\VehiculeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Transport;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;



#[ORM\Entity(repositoryClass: VehiculeRepository::class)]
class Vehicule
{
    public const CAPACITY_MAX_MESSAGE = "La capacité ne peut pas dépasser {{ limit }} personnes.";
    public const UNIT_PRICE_MIN_MESSAGE = "Le prix unitaire doit être supérieur à zéro.";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'num_v')]
    private ?int $numV = null;

    #[Assert\NotBlank(message: "could'nt be nul")]
    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    #[Assert\Range(
        max: 15,
        maxMessage: self::CAPACITY_MAX_MESSAGE
    )]
    #[Assert\NotBlank(message: "could'nt be nul")]
    private ?int $capacite = null;

    #[ORM\Column]
    #[Assert\GreaterThan(
        value: 0,
        message: self::UNIT_PRICE_MIN_MESSAGE
    )]
    #[Assert\NotBlank(message: "could'nt be nul")]
    private ?int $prixuni = null;

    

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;
/***************************** */


#[ORM\ManyToOne(targetEntity: Transpoteur::class)]
    #[ORM\JoinColumn(name: 'num_ch', referencedColumnName: 'num_ch')]
    private ?Transpoteur $transpoteur;

    
    public function getTranspoteur(): ?Transpoteur
    {
        return $this->transpoteur;
    }

    public function setTranspoteur(?Transpoteur $transpoteur): static
    {
        $this->transpoteur = $transpoteur;

        return $this;
    }




/**************************** */
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
            $transport->setVehicule($this);
        }

        return $this;
    }

    public function removeVehicule(Transport $transport): static
    {
        if ($this->Transport->removeElement($transport)) {
            // set the owning side to null (unless already changed)
            if ($transport->getVehicule() === $this) {
                $transport->setVehicule(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getNumV(); // Supposons que 'nom' est une propriété de votre entité Livreur
    }












    public function getNumV(): ?int
    {
        return $this->numV;
    }

    public function setNumV(int $numV): static
    {
        $this->numV = $numV;

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

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): static
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getPrixuni(): ?int
    {
        return $this->prixuni;
    }

    public function setPrixuni(int $prixuni): static
    {
        $this->prixuni = $prixuni;

        return $this;
    }

  

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }
}
