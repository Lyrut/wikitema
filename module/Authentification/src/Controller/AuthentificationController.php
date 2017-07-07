<?php

namespace Authentification\Controller;

use Authentification\Entity\User;
use Authentification\Form\LoginForm;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\SessionManager;
use Zend\View\Model\ViewModel;

class AuthentificationController extends AbstractActionController {

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

    public function loginAction() {
        
        $isLoginError = false;
        
        $this->verifyIfUserAlreadyConnected();
        
        // Create user form
        $form = new LoginForm();

        if ($this->getRequest()->isPost()) {

            $data = $this->params()->fromPost();

            $form->setData($data);

            // Validate form
            if ($form->isValid()) {
                $user = new User();
                $user->setEmail($data['email']);
                $user->setPassword($data['password']);

                $this->verifyIfUserAlreadyConnected();
                
                // Authenticate with login/password.
                $authAdapter = $this->authService->getAdapter();
                $authAdapter->setEmail($user->getEmail());
                $authAdapter->setPassword($user->getPassword());
                $result = $this->authService->authenticate();

                if ($result->getCode() == Result::SUCCESS) {
                    $isLoginError = false;
                    $this->flashMessenger()->addSuccessMessage('Connexion Reussie');
                    $this->redirect()->toRoute('home');
                } else {
                    $this->flashMessenger()->addErrorMessage('Le mot de passe ne correspond pas');
                    $isLoginError = true;
                }
            }
        }

        return new ViewModel([
            'isLoginError' => $isLoginError,
            'form' => $form
        ]);
    }
    
    public function logoutAction() 
    {        
        $this->verifyIfUserIsNotConnected();
        
        // Remove identity from session.
        $this->authService->clearIdentity();
        $this->flashMessenger()->addSuccessMessage('Déconnexion Reussie');
        $this->redirect()->toRoute('connexion');
        return [];
    }
    
    public function verifyloginAction()
    {
        dump($this->authService->getIdentity());
        return [];
    }

    private function verifyIfUserAlreadyConnected() {
        if ($this->authService->getIdentity() != null) {
            $this->flashMessenger()->addErrorMessage("Vous êtes déjà connecté");
            $this->redirect()->toRoute('home');
        }
    }
    
    private function verifyIfUserIsNotConnected()
    {
        if ($this->authService->getIdentity() == null) {
            $this->flashMessenger()->addErrorMessage("Aucun utilisateur de connecté");
            $this->redirect()->toRoute('connexion');
        }
    }

}
