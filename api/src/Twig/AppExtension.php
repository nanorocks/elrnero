<?php

namespace App\Twig;

use App\Service\DatabaseSchemaService;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class AppExtension extends AbstractExtension implements GlobalsInterface
{
    private $databaseSchemaService;

    public function __construct(DatabaseSchemaService $databaseSchemaService)
    {
        $this->databaseSchemaService = $databaseSchemaService;
    }

    public function getGlobals(): array
    {
        return [
            'database_schema' => $this->databaseSchemaService->getSchemaName(),
        ];
    }
}