<?php

namespace App\Entity;

use App\Repository\QuotientFamilialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuotientFamilialRepository::class)]
class QuotientFamilial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?int $quotientMini = null;

    /**
     * @var Collection<int, Responsable>
     */
    #[ORM\OneToMany(targetEntity: Responsable::class, mappedBy: 'quotientFamilial')]
    private Collection $responsable;

    #[ORM\OneToOne(mappedBy: 'QuotientFamilial', cascade: ['persist', 'remove'])]
    private ?Tarif $tarif = null;

    public function __construct()
    {
        $this->responsable = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getQuotientMini(): ?int
    {
        return $this->quotientMini;
    }

    public function setQuotientMini(int $quotientMini): static
    {
        $this->quotientMini = $quotientMini;

        return $this;
    }

    /**
     * @return Collection<int, Responsable>
     */
    public function getResponsable(): Collection
    {
        return $this->responsable;
    }

    public function addResponsable(Responsable $responsable): static
    {
        if (!$this->responsable->contains($responsable)) {
            $this->responsable->add($responsable);
            $responsable->setQuotientFamilial($this);
        }

        return $this;
    }

    public function removeResponsable(Responsable $responsable): static
    {
        if ($this->responsable->removeElement($responsable)) {
            // set the owning side to null (unless already changed)
            if ($responsable->getQuotientFamilial() === $this) {
                $responsable->setQuotientFamilial(null);
            }
        }

        return $this;
    }

    public function getTarif(): ?Tarif
    {
        return $this->tarif;
    }

    public function setTarif(?Tarif $tarif): static
    {
        // unset the owning side of the relation if necessary
        if ($tarif === null && $this->tarif !== null) {
            $this->tarif->setQuotientFamilial(null);
        }

        // set the owning side of the relation if necessary
        if ($tarif !== null && $tarif->getQuotientFamilial() !== $this) {
            $tarif->setQuotientFamilial($this);
        }

        $this->tarif = $tarif;

        return $this;
    }
}
