<?php

namespace App\Entity;

use App\Repository\TypeCoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeCoursRepository::class)]
class TypeCours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $libelle = null;

    /**
     * @var Collection<int, Cours>
     */
    #[ORM\OneToMany(targetEntity: Cours::class, mappedBy: 'typecours')]
    private Collection $cours;

    #[ORM\OneToOne(mappedBy: 'TypeCours', cascade: ['persist', 'remove'])]
    private ?Tarif $tarif = null;

    public function __construct()
    {
        $this->cours = new ArrayCollection();
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

    /**
     * @return Collection<int, Cours>
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }

    public function addCour(Cours $cour): static
    {
        if (!$this->cours->contains($cour)) {
            $this->cours->add($cour);
            $cour->setTypecours($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): static
    {
        if ($this->cours->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getTypecours() === $this) {
                $cour->setTypecours(null);
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
            $this->tarif->setTypeCours(null);
        }

        // set the owning side of the relation if necessary
        if ($tarif !== null && $tarif->getTypeCours() !== $this) {
            $tarif->setTypeCours($this);
        }

        $this->tarif = $tarif;

        return $this;
    }
}
