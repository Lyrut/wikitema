<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
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
        return new ViewModel();
    }
}
