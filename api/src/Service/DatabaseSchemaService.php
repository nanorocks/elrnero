<?php

// src/Service/DatabaseSchemaService.php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class DatabaseSchemaService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getSchemaName(): string
    {
        $connection = $this->entityManager->getConnection();
        return $connection->getDatabase();
    }
}