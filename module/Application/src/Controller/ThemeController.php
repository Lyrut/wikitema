<?php

namespace Application\Controller;

use Application\Entity\Theme;
use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\SessionManager;
use Zend\View\Model\ViewModel;

class ThemeController extends AbstractActionController
{
    /**
     * Authentication service.
     * @var AuthenticationService
     */
    private $authService;

    /**
     * Session manager.
     * @var SessionManager
     */
    private $sessionManager;

    /**
     * Constructs the controller.
     */
    public function __construct($entityManager, $authService, $sessionManager) {
        $this->authService = $authService;
        $this->sessionManager = $sessionManager;
    }
    
    public function indexAction()
    {
        $themes = $this->entityManager->getRepository(Theme::class)
                ->findBy([], ['id' => 'ASC']);

        return new ViewModel([
            'themes' => $themes
        ]);
    }
    
    public function addAction()
    {
        $themes = $this->entityManager->getRepository(Theme::class)
                ->findBy([], ['id' => 'ASC']);

        return new ViewModel([
            'themes' => $themes
        ]);
    }
}
