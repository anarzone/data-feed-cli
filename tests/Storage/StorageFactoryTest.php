<?php
declare(strict_types=1);

namespace App\Tests\Storage;

use App\Storage\StorageFactory;
use App\Storage\MongoDBStorage;
use App\Storage\MySQLStorage;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class StorageFactoryTest extends TestCase
{
    private StorageFactory $factory;

    protected function setUp(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $documentManager = $this->createMock(DocumentManager::class);
        $serializer = $this->createMock(SerializerInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $this->factory = new StorageFactory(
            $entityManager,
            $documentManager,
            $serializer,
            $logger
        );
    }

    public function testCreateReturnsMySQLStorageByDefault(): void
    {
        // When no type is passed or an unknown type is passed, default should be MySQLStorage.
        $storage = $this->factory->create();
        $this->assertInstanceOf(MySQLStorage::class, $storage);

        $storage = $this->factory->create('unknown');
        $this->assertInstanceOf(MySQLStorage::class, $storage);
    }

    public function testCreateReturnsMongoDBStorageWhenSpecified(): void
    {
        $storage = $this->factory->create('mongodb');
        $this->assertInstanceOf(MongoDBStorage::class, $storage);
    }
}
