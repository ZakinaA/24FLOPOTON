<?php

namespace App\Entity;

use App\Repository\TarifRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TarifRepository::class)]
class Tarif
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $montant = null;

    #[ORM\OneToOne(inversedBy: 'QuotientFamilial', cascade: ['persist', 'remove'])]
    private ?TypeCours $TypeCours = null;

    #[ORM\OneToOne(inversedBy: 'tarif', cascade: ['persist', 'remove'])]
    private ?QuotientFamilial $QuotientFamilial = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getTypeCours(): ?TypeCours
    {
        return $this->TypeCours;
    }

    public function setTypeCours(?TypeCours $TypeCours): static
    {
        $this->TypeCours = $TypeCours;

        return $this;
    }

    public function getQuotientFamilial(): ?QuotientFamilial
    {
        return $this->QuotientFamilial;
    }

    public function setQuotientFamilial(?QuotientFamilial $QuotientFamilial): static
    {
        $this->QuotientFamilial = $QuotientFamilial;

        return $this;
    }
}
