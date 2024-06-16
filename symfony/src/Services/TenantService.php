<?php

namespace App\Service;

use App\Entity\Tenant;
use Doctrine\ORM\EntityManagerInterface;

class TenantService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function switchTenant(Tenant $tenant)
    {
        $this->em->getConnection()->executeStatement('SET search_path TO ' . $tenant->getSchema());
    }
}