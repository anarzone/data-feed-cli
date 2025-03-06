<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

#[ODM\Document(collection: "products")]
class ProductDocument
{
    #[ODM\Id]
    private ?string $id = null;

    #[ODM\Field(type: "string")]
    private string $gtin;

    #[ODM\Field(type: "string", nullable:  true)]
    private ?string $language = 'en';

    #[ODM\Field(type: "string", nullable:  true)]
    private ?string $title;

    #[ODM\Field(type: "string", nullable: true)]
    private ?string $picture = null;

    #[ODM\Field(type: "string", nullable: true)]
    private ?string $description = null;

    #[ODM\Field(type: "float", nullable: true)]
    private ?float $price = null;

    #[ODM\Field(type: "int")]
    private int $stock = 0;

    public function getId(): ?string
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
