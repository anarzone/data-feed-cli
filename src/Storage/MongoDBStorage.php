<?php

namespace App\Storage;

use App\Document\ProductDocument;
use App\Dto\ProductDto;
use Doctrine\ODM\MongoDB\DocumentManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\SerializerInterface;

readonly class MongoDBStorage implements ProductStorageInterface
{
    public function __construct(
        private DocumentManager     $documentManager,
        private SerializerInterface $serializer,
        private LoggerInterface     $logger
    )
    {
    }

    public function store(ProductDto $dto): void
    {

        $document = $this->serializer->denormalize($dto, ProductDocument::class);

        $this->logger->info("Storing product: " . json_encode($dto));

        $this->documentManager->persist($document);
        $this->documentManager->flush();
    }
}
