<?php
declare(strict_types=1);

namespace App\Service;

use App\Dto\ProductDto;
use App\Storage\ProductStorageInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CSVImportService
{
    private ProductStorageInterface $storage;

    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly LoggerInterface $logger
    )
    {
    }

    public function import(string $csvFilePath): bool
    {
        if (!file_exists($csvFilePath)) {
            $this->logger->error("CSV file not found at path: {$csvFilePath}");
            return false;
        }

        if (($handle = fopen($csvFilePath, 'r')) === false) {
            $this->logger->error("Unable to open CSV file: {$csvFilePath}");
            return false;
        }

        // Read header row (expected: gtin,language,title,picture,description,price,stock)
        $header = fgetcsv($handle);
        if ($header === false) {
            $this->logger->error("CSV file is empty or invalid: $csvFilePath");
            fclose($handle);
            return false;
        }

        while (($data = fgetcsv($handle)) !== false) {
            $row = array_combine($header, $data);

            // Create a DTO and map CSV data to it.
            $dto = new ProductDto();
            $dto->gtin        = trim($row['gtin'] ?? '');
            $dto->language    = trim($row['language'] ?? '');
            $dto->title       = trim($row['title'] ?? '');
            $dto->picture     = trim($row['picture'] ?? '');
            $dto->description = trim($row['description'] ?? '');
            $dto->price       = isset($row['price']) && is_numeric($row['price']) ? (float)$row['price'] : null;
            $dto->stock       = isset($row['stock']) ? (int)$row['stock'] : 0;

            $errors = $this->validator->validate($dto);
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $this->logger->error("Validation error for row: " . $error->getPropertyPath() . " " . $error->getMessage());
                }

                throw new ValidationFailedException($dto, $errors);
            }

            try {
                $this->storage->store($dto);
            } catch (\Exception $e) {
                $this->logger->error("Error storing data: " . $e->getMessage());
            }
        }

        fclose($handle);
        return true;
    }

    public function setStorage(ProductStorageInterface $storage): void
    {
        $this->storage = $storage;
    }
}
