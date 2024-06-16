<?php

namespace App\Command;

use Doctrine\Migrations\DependencyFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Migrations\Tools\Console\Command\MigrateCommand;

#[AsCommand(
    name: 'app:migrate-central',
    description: 'Run central migrations',
)]
class MigrateCentralCommand extends Command
{
    private $dependencyFactory;

    public function __construct(DependencyFactory $dependencyFactory)
    {
        parent::__construct();
        $this->dependencyFactory = $dependencyFactory;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Set the default schema to central
        $this->dependencyFactory->getConnection()->executeStatement('CREATE SCHEMA IF NOT EXISTS central');
        $this->dependencyFactory->getConnection()->executeStatement('SET search_path TO central');

        $migrateCommand = new MigrateCommand($this->dependencyFactory);
        $migrateCommand->setApplication($this->getApplication());
        $migrateCommand->setName('doctrine:migrations:migrate');

        // Execute the migration
        $inputArgs = new ArrayInput([]);
        $inputArgs->setInteractive(false);
        $migrateCommand->run($inputArgs, $output);

        $io->success('Central migrations completed! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}