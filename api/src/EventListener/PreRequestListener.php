<?php

namespace App\EventListener;

use App\DBAL\MultiDbConnectionWrapper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

final class PreRequestListener
{
    public function __construct(private EntityManagerInterface $em)
    {}
    
    #[AsEventListener(event: KernelEvents::REQUEST)]
    public function onKernelRequest(RequestEvent $event): void
    {
        $connection = $this->em->getConnection();
        
        if(!$connection instanceof MultiDbConnectionWrapper) {
            throw new \RuntimeException('Wrong connection');
        }

        $request = $event->getRequest();
        $host = $request->getHost();
        
        $parts = explode('.', $host);
        $subdomain = $parts[0]; // The first part is the subdomain

        if(count($parts) === 1) {
            throw new \RuntimeException('Wrong connection');
        }

        // Optionally, you may want to handle special cases like 'www'
        if ($subdomain === 'www' && count($parts) > 2) {
            $subdomain = $parts[1]; // Adjust for 'www.example.com' format
        }
         
        $connection->selectDatabase($subdomain);

    }
}