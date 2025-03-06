<?php

namespace App\Storage;

use App\Dto\ProductDto;

interface ProductStorageInterface
{
    public function store(ProductDto $dto): void;
}
