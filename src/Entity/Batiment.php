<?php

namespace App\Entity;

use App\Repository\BatimentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BatimentRepository::class)
 */
class Batiment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $denomination;

    /**
     * @ORM\OneToMany(targetEntity=Rapport::class, mappedBy="batiment")
     */
    private $rapport;

    public function __construct()
    {
        $this->rapport = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDenomination(): ?string
    {
        return $this->denomination;
    }

    public function setDenomination(string $denomination): self
    {
        $this->denomination = $denomination;

        return $this;
    }

    /**
     * @return Collection|Rapport[]
     */
    public function getRapport(): Collection
    {
        return $this->rapport;
    }

    public function addRapport(Rapport $rapport): self
    {
        if (!$this->rapport->contains($rapport)) {
            $this->rapport[] = $rapport;
            $rapport->setBatiment($this);
        }

        return $this;
    }

    public function removeRapport(Rapport $rapport): self
    {
        if ($this->rapport->contains($rapport)) {
            $this->rapport->removeElement($rapport);
            // set the owning side to null (unless already changed)
            if ($rapport->getBatiment() === $this) {
                $rapport->setBatiment(null);
            }
        }

        return $this;
    }

    public function __toString(){

        return(string) $this->denomination;
    }  
}
