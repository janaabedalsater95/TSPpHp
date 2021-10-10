<?php

namespace App\Entity;

use App\Repository\OwnerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OwnerRepository::class)
 */
class Owner
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $familyName;

    /**
     * @ORM\Column(type="text")
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity=Room::class, mappedBy="owner")
     */
    private $summary;

    public function __construct()
    {
        $this->summary = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    public function setFamilyName(string $familyName): self
    {
        $this->familyName = $familyName;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection|Room[]
     */
    public function getSummary(): Collection
    {
        return $this->summary;
    }

    public function addSummary(Room $summary): self
    {
        if (!$this->summary->contains($summary)) {
            $this->summary[] = $summary;
            $summary->setOwner($this);
        }

        return $this;
    }

    public function removeSummary(Room $summary): self
    {
        if ($this->summary->removeElement($summary)) {
            // set the owning side to null (unless already changed)
            if ($summary->getOwner() === $this) {
                $summary->setOwner(null);
            }
        }

        return $this;
    }
    public function __toString() {
        return $this->name. " " .$this->address. " ".$this->country. " ".$this->familyName. " (" . $this->id . ")" ;
    }
}
