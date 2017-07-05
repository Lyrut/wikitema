<?php
namespace Application\Controller\Factory;

use Application\Controller\ThemeController;
use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Session\SessionManager;

class ThemeControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $authenticationService = $container->get(AuthenticationService::class);
        $sessionManager = $container->get(SessionManager::class);
        
        // Instantiate the controller and inject dependencies
        return new ThemeController($entityManager,$authenticationService, $sessionManager);
    }
}

