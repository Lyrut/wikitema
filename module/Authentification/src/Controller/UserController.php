<?php

namespace Authentification\Controller;

use Authentification\Form\UserForm;
use Doctrine\ORM\EntityManager;
use Exception;
use Authentification\Entity\User;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{
    
     /**
     * Entity manager.
     * @var EntityManager
     */
    private $entityManager;
    
    /**
     * Constructor. 
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    /**
     * This is the default "index" action of the controller. It displays the 
     * list of users.
     */
    public function indexAction() 
    {
        $users = $this->entityManager->getRepository(User::class)
                ->findBy([], ['id'=>'ASC']);
        
        return new ViewModel([
            'users' => $users
        ]);
    }
    
    /**
     * This action displays a page allowing to add a new user.
     */
    public function addAction()
    {
        // Create user form
        $form = new UserForm('create', $this->entityManager);
        
        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {
            
            // Fill in the form with POST data
            $data = $this->params()->fromPost();            
            
            $form->setData($data);
            
            // Validate form
            if($form->isValid()) {
                
                // Get filtered and validated data
                $data = $form->getData();
                
                //Ajouter la vérification de l'email dans la bdd pour ne pas avoir de doublon
                
                // Add user.
                $user = $this->addUser($data);
                
                // Redirect to "view" page
                return $this->redirect()->toRoute('users', 
                        ['action'=>'view', 'id'=>$user->getId()]);                
            }               
        } 
        
        return new ViewModel([
                'form' => $form
            ]);
    }
    
    private function addUser($data) 
    {
        // Do not allow several users with the same email address.
        if($this->checkIfUserExists($data['email'])) {
            throw new Exception("User with email address " . $data['$email'] . " already exists");
        }
        
        // Create new User entity.
        $user = new User();
        $user->setEmail($data['email']);
        $user->setFullName($data['full_name']);        

        // a faire (encrypter le mot de passe)
        /*$bcrypt = new Bcrypt();
        $passwordHash = $bcrypt->create($data['password']);        
        $user->setPassword($passwordHash);
        */
        
        $currentDate = date('Y-m-d H:i:s');
        $user->setDateCreated($currentDate);        
                
        // Add the entity to the entity manager.
        $this->entityManager->persist($user);
        
        // Apply changes to database.
        $this->entityManager->flush();
        
        return $user;
    }
    
    private function checkIfUserExists($email) {
        
        $user = $this->entityManager->getRepository(User::class)
                ->findOneByEmail($email);
        
        return $user !== null;
    }
 
}