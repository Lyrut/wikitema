<?php

namespace Application\Controller;

use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\SessionManager;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
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
        
        $user = $this->identity();
        if($user == null) 
            $this->redirect()->toRoute("connexion");
        else 
            $this->redirect()->toRoute("index.articles");

        return new ViewModel();
    }
}
