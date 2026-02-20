<?php

namespace App\Entity;

use App\Repository\FeesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: FeesRepository::class)]
class Fees
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?float $price = null;

    /**
     * @var Collection<int, FallasParticipants>
     */
    #[ORM\OneToMany(targetEntity: FallasParticipants::class, mappedBy: 'fee')]
    private Collection $fallasParticipants;

    public function __construct()
    {
        $this->fallasParticipants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, FallasParticipants>
     */
    public function getFallasParticipants(): Collection
    {
        return $this->fallasParticipants;
    }

    public function addFallasParticipant(FallasParticipants $fallasParticipant): static
    {
        if (!$this->fallasParticipants->contains($fallasParticipant)) {
            $this->fallasParticipants->add($fallasParticipant);
            $fallasParticipant->setFee($this);
        }

        return $this;
    }

    public function removeFallasParticipant(FallasParticipants $fallasParticipant): static
    {
        if ($this->fallasParticipants->removeElement($fallasParticipant)) {
            // set the owning side to null (unless already changed)
            if ($fallasParticipant->getFee() === $this) {
                $fallasParticipant->setFee(null);
            }
        }

        return $this;
    }
}
