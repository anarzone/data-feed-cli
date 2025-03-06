<?php
declare(strict_types=1);

namespace App\Tests\Service;

use App\Dto\ProductDto;
use App\Service\CSVImportService;
use App\Storage\ProductStorageInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CSVImportServiceTest extends TestCase
{
    private string $tempCsvFile;

    protected function setUp(): void
    {
        // Create a temporary CSV file for testing
        $this->tempCsvFile = tempnam(sys_get_temp_dir(), 'csv');
        file_put_contents($this->tempCsvFile, "gtin,language,title,picture,description,price,stock\n12345678901234,en,Test Product,http://example.com/image.jpg,Test description,19.99,100\n");
    }

    protected function tearDown(): void
    {
        if (file_exists($this->tempCsvFile)) {
            unlink($this->tempCsvFile);
        }
    }

    public function testImportReturnsFalseIfFileNotFound(): void
    {
        $storageMock = $this->createMock(ProductStorageInterface::class);
        $validatorMock = $this->createMock(ValidatorInterface::class);
        $loggerMock = $this->createMock(LoggerInterface::class);

        $importService = new CSVImportService($validatorMock, $loggerMock);
        $importService->setStorage($storageMock);

        $result = $importService->import('/non/existing/path.csv');

        $this->assertFalse($result);
    }

    public function testImportProcessesRowsAndCallsStore(): void
    {
        // Expect the store() method to be called once with a dto containing our test data.
        $storageMock = $this->createMock(ProductStorageInterface::class);
        $storageMock->expects($this->once())
            ->method('store')
            ->with($this->callback(function (ProductDto $dto) {
                return $dto->gtin === '12345678901234'
                    && $dto->language === 'en'
                    && $dto->title === 'Test Product'
                    && $dto->picture === 'http://example.com/image.jpg'
                    && $dto->description === 'Test description'
                    && $dto->price === 19.99
                    && $dto->stock === 100;
            }));

        $loggerMock = $this->createMock(LoggerInterface::class);
        $validatorMock = $this->createMock(ValidatorInterface::class);
        // We don't expect errors, so no need to set expectations for error logging.

        $importService = new CSVImportService($validatorMock, $loggerMock);
        $importService->setStorage($storageMock);

        $result = $importService->import($this->tempCsvFile);

        $this->assertTrue($result);
    }
}
