<?php

namespace App\Command;

use App\Repository\TenantRepository;
use Doctrine\Migrations\DependencyFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Migrations\Tools\Console\Command\MigrateCommand;

#[AsCommand(
    name: 'app:migrate-tenants',
    description: 'Run migrations for all tenants',
)]
class MigrateTenantsCommand extends Command
{
    private $tenantRepository;
    private $dependencyFactory;

    public function __construct(TenantRepository $tenantRepository, DependencyFactory $dependencyFactory)
    {
        $this->tenantRepository = $tenantRepository;
        $this->dependencyFactory = $dependencyFactory;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $tenants = $this->tenantRepository->findAll();

        foreach ($tenants as $tenant) {
            $output->writeln('Migrating tenant: ' . $tenant->getName());

            // Set the schema search path
            $this->dependencyFactory->getConnection()->executeStatement('SET search_path TO ' . $tenant->getSchema());

            // Create a migrate command for tenant migrations
            $migrateCommand = new MigrateCommand($this->dependencyFactory);
            $migrateCommand->setApplication($this->getApplication());
            $migrateCommand->setName('doctrine:migrations:migrate');

            // Execute the migration
            $inputArgs = new ArrayInput([
                '--namespace' => 'DoctrineMigrations\Tenant'
            ]);
            $inputArgs->setInteractive(false);
            $migrateCommand->run($inputArgs, $output);
        }

        $io->success('Migrations on all tenants completed! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}