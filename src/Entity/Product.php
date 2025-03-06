<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: "products")]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 14, unique: true)]
    private string $gtin;

    #[ORM\Column(type: "string", length: 10, nullable: true)]
    private ?string $language = 'en';

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $title;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: "float", nullable: true)]
    private ?float $price = null;

    #[ORM\Column(type: "integer")]
    private int $stock = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGtin(): string
    {
        return $this->gtin;
    }

    public function setGtin(string $gtin): self
    {
        $this->gtin = $gtin;
        return $this;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;
        return $this;
    }
}
