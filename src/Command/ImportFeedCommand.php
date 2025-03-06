<?php

namespace App\Command;

use App\Service\CSVImportService;
use App\Storage\StorageFactory;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:import-feed',
    description: 'Import feed for a given Storage',
)]
class ImportFeedCommand extends Command implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        private readonly StorageFactory   $storageFactory,
        private readonly CSVImportService $csvImportService,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Imports data from a CSV file into the selected database.')
            ->addOption(
                'db',
                null,
                InputOption::VALUE_OPTIONAL,
                'Database storage to use (mysql or mongodb)'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Get the database type from command-line option or fallback to .env.
        $dbType = $input->getOption('db');
        $storage = $this->storageFactory->create($dbType);

        // Set the storage for the CSV import service.
        $this->csvImportService->setStorage($storage);

        // Retrieve CSV file path from environment variables or use default.
        $csvFilePath = $_ENV['CSV_FILE_PATH'] ?? __DIR__ . '/../../dataset/feed.csv';

        if ($this->csvImportService->import($csvFilePath)) {
            $output->writeln('Data imported successfully.');
            return Command::SUCCESS;
        }

        $output->writeln('Data import failed.');
        return Command::FAILURE;
    }
}
