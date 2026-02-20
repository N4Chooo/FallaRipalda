<?php

namespace App\Entity;

use App\Repository\MonumentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MonumentRepository::class)]
class Monument
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $artist = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $photo = null;

    #[ORM\Column(length: 255)]
    private ?string $sketch = null;

    #[ORM\Column(length: 255)]
    private ?string $pardoned_doll = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prices = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $criticism = null;

    #[ORM\Column]
    private ?\DateTime $year = null;

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

    public function getArtist(): ?string
    {
        return $this->artist;
    }

    public function setArtist(?string $artist): static
    {
        $this->artist = $artist;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getSketch(): ?string
    {
        return $this->sketch;
    }

    public function setSketch(string $sketch): static
    {
        $this->sketch = $sketch;

        return $this;
    }

    public function getPardonedDoll(): ?string
    {
        return $this->pardoned_doll;
    }

    public function setPardonedDoll(string $pardoned_doll): static
    {
        $this->pardoned_doll = $pardoned_doll;

        return $this;
    }

    public function getPrices(): ?string
    {
        return $this->prices;
    }

    public function setPrices(?string $prices): static
    {
        $this->prices = $prices;

        return $this;
    }

    public function getCriticism(): ?string
    {
        return $this->criticism;
    }

    public function setCriticism(?string $criticism): static
    {
        $this->criticism = $criticism;

        return $this;
    }

    public function getYear(): ?\DateTime
    {
        return $this->year;
    }

    public function setYear(\DateTime $year): static
    {
        $this->year = $year;

        return $this;
    }
}
