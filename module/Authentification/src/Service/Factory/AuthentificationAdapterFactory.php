<?php

namespace Authentification\Service\Factory;

use Authentification\Service\AuthentificationAdapter;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class AuthentificationAdapterFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        // Create the service and inject dependencies into its constructor.
        return new AuthentificationAdapter($entityManager);
    }
}

