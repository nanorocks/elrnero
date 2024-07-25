<?php

namespace App\Controller\Admin;

use Doctrine\DBAL\Connection;
use App\DBAL\MultiDbConnectionWrapper;
use App\Utils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SettingsController extends AbstractController
{
    #[Route('/admin/settings', name: 'settings_index')]
    public function index(Connection $connection, Request $request): Response
    {

        $schemaManager = $connection->createSchemaManager();
                
        $databases = $schemaManager->listDatabases();

        // NOTE: Remove the default databases in PGSQL
        $databases = array_diff($databases, ['postgres', 'template1', 'template0']);
        
        $domain = Utils::extractPrimaryDomain($request->getHost());
        
        return $this->render('admin/settings/index.html.twig', [
            'tenants' => $databases,
            'domain' => $domain
        ]);
    }
}