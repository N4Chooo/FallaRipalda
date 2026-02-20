<?php

namespace App\Entity;

use App\Repository\FallasParticipantsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FallasParticipantsRepository::class)]
class FallasParticipants
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rewards = null;

    #[ORM\Column]
    private ?bool $payment_status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rol = null;

    #[ORM\ManyToOne(inversedBy: 'fallasParticipants')]
    private ?Fees $fee = null;

    /**
     * @var Collection<int, Events>
     */
    #[ORM\ManyToMany(targetEntity: Events::class, inversedBy: 'fallasParticipants')]
    private Collection $event;

    #[ORM\Column(length: 9, unique: true)]
    private ?string $dni = null;

    public function __construct()
    {
        $this->event = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getRewards(): ?string
    {
        return $this->rewards;
    }

    public function setRewards(?string $rewards): static
    {
        $this->rewards = $rewards;

        return $this;
    }

    public function isPaymentStatus(): ?bool
    {
        return $this->payment_status;
    }

    public function setPaymentStatus(bool $payment_status): static
    {
        $this->payment_status = $payment_status;

        return $this;
    }

    public function getRol(): ?string
    {
        return $this->rol;
    }

    public function setRol(?string $rol): static
    {
        $this->rol = $rol;

        return $this;
    }

    public function getFee(): ?Fees
    {
        return $this->fee;
    }

    public function setFee(?Fees $fee): static
    {
        $this->fee = $fee;

        return $this;
    }

    /**
     * @return Collection<int, Events>
     */
    public function getEvent(): Collection
    {
        return $this->event;
    }

    public function addEvent(Events $event): static
    {
        if (!$this->event->contains($event)) {
            $this->event->add($event);
        }

        return $this;
    }

    public function removeEvent(Events $event): static
    {
        $this->event->removeElement($event);

        return $this;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): static
    {
        $this->dni = $dni;

        return $this;
    }
}
