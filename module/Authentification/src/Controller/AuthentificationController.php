<?php

namespace Authentification\Controller;

use Authentification\Entity\User;
use Authentification\Form\LoginForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AuthentificationController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function loginAction()
    {
        // Create user form
        $form = new LoginForm($this->entityManager);
        
        if ($this->getRequest()->isPost()) {
            
            $data = $this->params()->fromPost();            
            
            $form->setData($data);
            
            // Validate form
            if($form->isValid()) {
                $user = new User();
                $user->setEmail($data['email']);
                $user->setPassword($data['password']);
            }               
        } 
        
        return new ViewModel([
                'form' => $form
            ]);
    }
}
