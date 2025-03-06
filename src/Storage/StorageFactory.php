<?php

namespace App\Storage;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\SerializerInterface;

readonly class StorageFactory
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private DocumentManager        $documentManager,
        private SerializerInterface    $serializer,
        private LoggerInterface        $logger
    ) {
    }

    public function create(?string $type = null): ProductStorageInterface
    {
        if ($type === null) {
            $type = $_ENV['DATABASE_TYPE'] ?? 'mysql';
        }

        switch (strtolower($type)) {
            case 'mongodb':
                $this->logger->info('Using MongoDB storage');
                return new MongoDBStorage($this->documentManager, $this->serializer, $this->logger);
            case 'mysql':
            default:
                $this->logger->info('Using MySQL storage');
                return new MySQLStorage($this->entityManager, $this->serializer, $this->logger);
        }
    }
}
