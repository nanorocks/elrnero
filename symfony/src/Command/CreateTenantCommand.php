<?php

namespace App\Command;

use App\Entity\Tenant;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:create-tenant',
    description: 'Create tenant per db schema for pgsql',
)]
class CreateTenantCommand extends Command
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::REQUIRED, 'Name for the tenant')
            ->addArgument('schema', InputArgument::REQUIRED, 'Schema for the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $name = $input->getArgument('name');
        $schema = $input->getArgument('schema');

        if ($name) {
            $io->note(sprintf('You passed an argument: %s', $name));
        }

        if ($schema) {
            $io->note(sprintf('You passed an argument: %s', $schema));
        }

        // Set the schema search path to central
        $this->em->getConnection()->executeStatement('SET search_path TO central');


        // Check for existing tenant with the same name or schema
        $existingTenant = $this->em->getRepository(Tenant::class)->findOneBy(['name' => $name]);
        if ($existingTenant) {
            $io->error('A tenant with this name already exists.');
            return Command::FAILURE;
        }

        $existingTenant = $this->em->getRepository(Tenant::class)->findOneBy(['schema' => $schema]);
        if ($existingTenant) {
            $io->error('A tenant with this schema already exists.');
            return Command::FAILURE;
        }

        // Create the schema
        $this->em->getConnection()->executeStatement('CREATE SCHEMA IF NOT EXISTS ' . $schema);

        // Set the schema search path to central
        $this->em->getConnection()->executeStatement('SET search_path TO central');

        // Create the tenant
        $tenant = new Tenant();
        $tenant->setName($name);
        $tenant->setSchema($schema);
        $this->em->persist($tenant);
        $this->em->flush();

        // Set the schema search path to the new tenant schema
        $this->em->getConnection()->executeStatement('SET search_path TO ' . $schema);

        // Create tables in the new schema
        $metadata = $this->em->getMetadataFactory()->getAllMetadata();
        // Filter metadata to exclude the Tenant entity
        $tenantMetadata = array_filter($metadata, function ($meta) {
            return $meta->getName() !== Tenant::class;
        });

        if (!empty($tenantMetadata)) {
            $schemaTool = new SchemaTool($this->em);
            $schemaTool->createSchema($tenantMetadata);
        }

        $io->success('Tenant created successfully!');

        return Command::SUCCESS;
    }
}