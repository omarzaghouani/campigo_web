<?php

namespace App\Entity;

use App\Repository\TransportRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Transpoteur;

use App\Entity\Vehicule;

#[ORM\Entity(repositoryClass: TransportRepository::class)]
class Transport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $num_t = null;

    

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: "could'nt be nul")]
    
    private ?\DateTimeInterface $dd = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: "could'nt be nul")]#[Assert\NotBlank]
   
    private ?\DateTimeInterface $da = null;


    #[ORM\Column]
    #[Assert\NotBlank(message: "could'nt be nul")]
    #[Assert\PositiveOrZero]
    private ?int $cout = null;



    #[ORM\ManyToOne(targetEntity: Transpoteur::class)]
    #[ORM\JoinColumn(name: 'num_ch', referencedColumnName: 'num_ch')]
    private ?Transpoteur $transpoteur;

    
    #[ORM\ManyToOne(targetEntity: Vehicule::class)]
    #[ORM\JoinColumn(name: 'num_v', referencedColumnName: 'num_v')]
    private ?Vehicule $vehicule;
    


    public function getTranspoteur(): ?Transpoteur
    {
        return $this->transpoteur;
    }

    public function setTranspoteur(?Transpoteur $transpoteur): static
    {
        $this->transpoteur = $transpoteur;

        return $this;
    }



    public function getVehicule(): ?Vehicule
    {
        return $this->vehicule;
    }

    public function setVehicule(?Vehicule $vehicule): static
    {
        $this->vehicule = $vehicule;

        return $this;
    }










    public function getNumT(): ?int
    {
        return $this->num_t;
    }

    public function setNumT(int $num_t): static
    {
        $this->num_t = $num_t;

        return $this;
    }



   
    public function getDd(): ?\DateTimeInterface
    {
        return $this->dd;
    }

    public function setDd(\DateTimeInterface $dd): static
    {
        $this->dd = $dd;

        return $this;
    }

    public function getDa(): ?\DateTimeInterface
    {
        return $this->da;
    }

    public function setDa(\DateTimeInterface $da): static
    {
        $this->da = $da;

        return $this;
    }



    public function getCout(): ?int
    {
        return $this->cout;
    }

    public function setCout(int $cout): static
    {
        $this->cout = $cout;

        return $this;
    }


    
}
