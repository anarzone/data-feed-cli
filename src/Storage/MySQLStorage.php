<?php

namespace App\Storage;

use App\Dto\ProductDto;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\SerializerInterface;

readonly class MySQLStorage implements ProductStorageInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface    $serializer,
        private LoggerInterface        $logger
    )
    {
    }

    public function store(ProductDto $dto): void
    {
        $product = $this->serializer->denormalize($dto, Product::class);

        $this->logger->info("Storing product: " . json_encode($dto));

        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }
}
