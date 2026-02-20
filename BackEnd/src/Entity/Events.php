<?php

namespace App\Entity;

use App\Repository\EventsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventsRepository::class)]
class Events
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?\DateTime $date = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?float $price = null;

    #[ORM\Column]
    private ?int $assistans = null;

    /**
     * @var Collection<int, FallasParticipants>
     */
    #[ORM\ManyToMany(targetEntity: FallasParticipants::class, mappedBy: 'event')]
    private Collection $fallasParticipants;

    public function __construct()
    {
        $this->fallasParticipants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getAssistans(): ?int
    {
        return $this->assistans;
    }

    public function setAssistans(int $assistans): static
    {
        $this->assistans = $assistans;

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
            $fallasParticipant->addEvent($this);
        }

        return $this;
    }

    public function removeFallasParticipant(FallasParticipants $fallasParticipant): static
    {
        if ($this->fallasParticipants->removeElement($fallasParticipant)) {
            $fallasParticipant->removeEvent($this);
        }

        return $this;
    }
}
