<?php

namespace App\Entity;

use App\Repository\AvatarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvatarRepository::class)]
class Avatar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_fichier = null;

    #[ORM\OneToMany(mappedBy: 'avatar', targetEntity: Personnage::class)]
    private Collection $personnages;


    public function __construct()
    {
        $this->personnages = new ArrayCollection();
        $this->etapes = new ArrayCollection();
        $this->finsPossibles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFichier(): ?string
    {
        return $this->nom_fichier;
    }

    public function setNomFichier(string $nom_fichier): self
    {
        $this->nom_fichier = $nom_fichier;

        return $this;
    }

    /**
     * @return Collection<int, Personnage>
     */
    public function getPersonnages(): Collection
    {
        return $this->personnages;
    }

    public function addPersonnage(Personnage $personnage): self
    {
        if (!$this->personnages->contains($personnage)) {
            $this->personnages->add($personnage);
            $personnage->setAvatar($this);
        }

        return $this;
    }

    public function removePersonnage(Personnage $personnage): self
    {
        if ($this->personnages->removeElement($personnage)) {
            // set the owning side to null (unless already changed)
            if ($personnage->getAvatar() === $this) {
                $personnage->setAvatar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Etape>
     */
    public function getEtapes(): Collection
    {
        return $this->etapes;
    }

    public function addEtape(Etape $etape): self
    {
        if (!$this->etapes->contains($etape)) {
            $this->etapes->add($etape);
            $etape->setFinAdventure($this);
        }

        return $this;
    }

    public function removeEtape(Etape $etape): self
    {
        if ($this->etapes->removeElement($etape)) {
            // set the owning side to null (unless already changed)
            if ($etape->getFinAdventure() === $this) {
                $etape->setFinAdventure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Etape>
     */
    public function getFinsPossibles(): Collection
    {
        return $this->finsPossibles;
    }

    public function addFinsPossible(Etape $finsPossible): self
    {
        if (!$this->finsPossibles->contains($finsPossible)) {
            $this->finsPossibles->add($finsPossible);
            $finsPossible->setFinAventure($this);
        }

        return $this;
    }

    public function removeFinsPossible(Etape $finsPossible): self
    {
        if ($this->finsPossibles->removeElement($finsPossible)) {
            // set the owning side to null (unless already changed)
            if ($finsPossible->getFinAventure() === $this) {
                $finsPossible->setFinAventure(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom_fichier;
    }
    
}