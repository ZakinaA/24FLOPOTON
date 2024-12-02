<?php

namespace App\Entity;

use App\Repository\InstrumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InstrumentRepository::class)]
class Instrument
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numSerie = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateAchat = null;

    #[ORM\Column]
    private ?float $prixAchat = null;

    #[ORM\Column(length: 255)]
    private ?string $utilisation = null;

    #[ORM\Column(length: 255)]
    private ?string $couleur = null;

    #[ORM\ManyToOne(inversedBy: 'instruments')]
    private ?TypeInstrument $typeInstrument = null;

    #[ORM\ManyToOne(inversedBy: 'instruments')]
    private ?Marque $marque = null;

    /**
     * @var Collection<int, Accessoire>
     */
    #[ORM\OneToMany(targetEntity: Accessoire::class, mappedBy: 'instrument')]
    private Collection $accessoire;

    /**
     * @var Collection<int, Modele>
     */
    #[ORM\ManyToMany(targetEntity: Modele::class, inversedBy: 'instruments')]
    private Collection $modele;

    /**
     * @var Collection<int, Contrat>
     */
    #[ORM\OneToMany(targetEntity: Contrat::class, mappedBy: 'instrument')]
    private Collection $contrats;

    public function __construct()
    {
        $this->accessoire = new ArrayCollection();
        $this->modele = new ArrayCollection();
        $this->contrats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumSerie(): ?string
    {
        return $this->numSerie;
    }

    public function setNumSerie(string $numSerie): static
    {
        $this->numSerie = $numSerie;

        return $this;
    }

    public function getDateAchat(): ?\DateTimeInterface
    {
        return $this->dateAchat;
    }

    public function setDateAchat(\DateTimeInterface $dateAchat): static
    {
        $this->dateAchat = $dateAchat;

        return $this;
    }

    public function getPrixAchat(): ?float
    {
        return $this->prixAchat;
    }

    public function setPrixAchat(float $prixAchat): static
    {
        $this->prixAchat = $prixAchat;

        return $this;
    }

    public function getUtilisation(): ?string
    {
        return $this->utilisation;
    }

    public function setUtilisation(string $utilisation): static
    {
        $this->utilisation = $utilisation;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): static
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getTypeInstrument(): ?TypeInstrument
    {
        return $this->typeInstrument;
    }

    public function setTypeInstrument(?TypeInstrument $typeInstrument): static
    {
        $this->typeInstrument = $typeInstrument;

        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * @return Collection<int, Accessoire>
     */
    public function getAccessoire(): Collection
    {
        return $this->accessoire;
    }

    public function addAccessoire(Accessoire $accessoire): static
    {
        if (!$this->accessoire->contains($accessoire)) {
            $this->accessoire->add($accessoire);
            $accessoire->setInstrument($this);
        }

        return $this;
    }

    public function removeAccessoire(Accessoire $accessoire): static
    {
        if ($this->accessoire->removeElement($accessoire)) {
            // set the owning side to null (unless already changed)
            if ($accessoire->getInstrument() === $this) {
                $accessoire->setInstrument(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Modele>
     */
    public function getModele(): Collection
    {
        return $this->modele;
    }

    public function addModele(Modele $modele): static
    {
        if (!$this->modele->contains($modele)) {
            $this->modele->add($modele);
        }

        return $this;
    }

    public function removeModele(Modele $modele): static
    {
        $this->modele->removeElement($modele);

        return $this;
    }

    /**
     * @return Collection<int, Contrat>
     */
    public function getContrats(): Collection
    {
        return $this->contrats;
    }

    public function addContrat(Contrat $contrat): static
    {
        if (!$this->contrats->contains($contrat)) {
            $this->contrats->add($contrat);
            $contrat->setInstrument($this);
        }

        return $this;
    }

    public function removeContrat(Contrat $contrat): static
    {
        if ($this->contrats->removeElement($contrat)) {
            // set the owning side to null (unless already changed)
            if ($contrat->getInstrument() === $this) {
                $contrat->setInstrument(null);
            }
        }

        return $this;
    }
}
