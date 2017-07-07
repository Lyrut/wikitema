<?php

namespace Authentification\Controller;

use Authentification\Entity\User;
use Authentification\Form\PasswordResetForm;
use Authentification\Form\UserForm;
use Doctrine\ORM\EntityManager;
use Zend\Math\Rand;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController {

    /**
     * Authentication service.
     * @var AuthenticationService
     */
    private $authService;
    
    /**
     * Entity manager.
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Constructor. 
     */
    public function __construct($entityManager, $authService, $sessionManager) {
        $this->entityManager = $entityManager;
        $this->authService = $authService;
        $this->sessionManager = $sessionManager;
    }

    private function checkIfUserExists($email) {

        $user = $this->entityManager->getRepository(User::class)
                ->findOneByEmail($email);

        return $user !== null;
    }

    /**
     * This is the default "index" action of the controller. It displays the 
     * list of users.
     */
    public function indexAction() {
        $this->verifyRoleForUser(1);
        
        $users = $this->entityManager->getRepository(User::class)
                ->findBy([], ['id' => 'ASC']);

        return new ViewModel([
            'users' => $users
        ]);
    }

    public function viewAction() {
        
        $id = (int) $this->params()->fromRoute('id', -1);
        if ($id < 1) {
            $this->flashMessenger()->addErrorMessage("l'id distribué n'est pas correcte");
            $this->redirect()->toRoute('list.users');
        }

        // Find a user with such ID.
        $user = $this->entityManager->getRepository(User::class)
                ->find($id);

        if ($user == null) {
            $this->flashMessenger()->addErrorMessage("l'utilisateur n'existe pas");
            $this->redirect()->toRoute('list.users');
        }
        
        $userAuth = $this->authService->getIdentity();
        if($userAuth == null) {
            $this->flashMessenger()->addErrorMessage("Vous n'avez pas accès à cette page");
            $this->redirect()->toRoute('connexion');
        }
        if(1 == $userAuth->getRole() || $user->getId() == $userAuth->getId())
        {
            return new ViewModel([
                'userAuth' => $userAuth,
                'user' => $user
            ]);
        } else {
            $this->flashMessenger()->addErrorMessage("Vous n'avez pas accès à cette page");
            $this->redirect()->toRoute('connexion');
        }
        return new ViewModel([
            'userAuth' => $userAuth,
            'user' => $user
        ]);
        
    }

    /**
     * This action displays a page allowing to add a new user.
     */
    public function addAction() {
        
        $user = $this->authService->getIdentity();
        if($user != null && $user->getRole() != 1) {
            $this->flashMessenger()->addErrorMessage("Vous n'avez pas accès à cette page");
            $this->redirect()->toRoute('connexion');
        }
        
        
        // Create user form
        if($user !=null && $user->getRole() == 1){
            $roles = array(1 => 'administrateur',2 => 'auteur',3 => 'abonné');
        }else{
            $roles = array(2 => 'auteur',3 => 'abonné');
        }
        
        $form = new UserForm('create', $this->entityManager,new User() ,$roles);
        
        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {

            // Fill in the form with POST data
            $data = $this->params()->fromPost();

            $form->setData($data);

            // Validate form
            if ($form->isValid()) {

                // Get filtered and validated data
                $data = $form->getData();

                if ($this->checkIfUserExists($data["email"])) {
                    $this->flashMessenger()->addMessage("L'utilisateur existe déjà.");
                    $this->redirect()->toRoute("list.users");
                }

                // Add user.
                $user = $this->addUser($data);

                // Redirect to "view" page
                return $this->redirect()->toRoute('view.users', ['id' => $user->getId()]);
            }
        }

        return new ViewModel([
            'user' => $this->authService->getIdentity(),
            'form' => $form
        ]);
    }

    private function addUser($data) {

        // Create new User entity.
        $user = new User();
        $user->setEmail($data['email']);
        $user->setFullName($data['full_name']);
        $user->setPseudo($data["pseudo"]);

        $user->setPassword(password_hash($data["password"], PASSWORD_BCRYPT));

        $user->setRole($data["select_role"]);

        $currentDate = date('Y-m-d H:i:s');
        $user->setDateCreated($currentDate);

        // Add the entity to the entity manager.
        $this->entityManager->persist($user);

        // Apply changes to database.
        $this->entityManager->flush();

        return $user;
    }
    
    private function verifyRoleForUser($level_of_access)
    {
        $user = $this->authService->getIdentity();
        if(!$user) {
            $this->flashMessenger()->addErrorMessage("Vous n'avez pas accès à cette page");
            $this->redirect()->toRoute('connexion');
        }
        if($level_of_access < $user->getRole())
        {
            $this->flashMessenger()->addErrorMessage("Vous n'avez pas accès à cette page");
            $this->redirect()->toRoute('connexion');
        }
    }

}
