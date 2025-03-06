<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class ProductDto
{
    #[Assert\NotBlank, Assert\Length(max: 14)]
    public string $gtin;

    #[Assert\NotBlank, Assert\Length(max: 10)]
    public ?string $language = null;

    #[Assert\NotBlank, Assert\Length(max: 255)]
    public ?string $title = null;

    #[Assert\Url, Assert\Length(max: 255)]
    public ?string $picture = null;

    #[Assert\Length(max: 1000)]
    public ?string $description = null;

    #[Assert\Type('numeric')]
    public ?float $price = null;

    #[Assert\NotNull, Assert\Type('integer'), Assert\GreaterThanOrEqual(0)]
    public int $stock;
}
