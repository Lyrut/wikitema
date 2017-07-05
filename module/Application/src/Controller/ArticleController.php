<?php

namespace Application\Controller;

use Application\Entity\Article;
use Application\Entity\Theme;
use Application\Form\ArticleForm;
use Authentification\Entity\User;
use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\SessionManager;
use Zend\View\Model\ViewModel;

class ArticleController extends AbstractActionController {

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
    private $entityManager;

    /**
     * Constructs the controller.
     */
    public function __construct($entityManager, $authService, $sessionManager) {
        $this->entityManager = $entityManager;
        $this->authService = $authService;
        $this->sessionManager = $sessionManager;
    }

    public function indexAction() {
        $articles = $this->entityManager->getRepository(Article::class)
                ->getLastArticles();

        return new ViewModel([
            'articles' => $articles
        ]);
    }

    public function addAction() {
        $themes = $this->entityManager->getRepository(Theme::class)
                ->findBy([], ['id' => 'ASC']);
        $t = [];
        foreach ($themes as $data) {
            $t[$data->getId()] = $data->getName();
        }

        // Create user form
        $form = new ArticleForm($t, $this->entityManager);

        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {

            // Fill in the form with POST data
            $data = $this->params()->fromPost();

            $form->setData($data);

            // Validate form
            if ($form->isValid()) {

                // Get filtered and validated data
                $data = $form->getData();

                // Add user.
                $article = $this->addArticle($data);

                // Redirect to "view" page
                return $this->redirect()->toRoute('view.articles', ['id' => $article->getId()]);
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    private function addArticle($data) {

        // Create new Article entity.
        $article = new Article();
        $article->setTitle($data['title']);
        $article->setText($data['text']);        
        $article->setTheme($this->getAndVerifyTheme($data['theme']));

        $currentDate = date('Y-m-d H:i:s');
        $article->setDate_created($currentDate);

        $user = $this->authService->getIdentity();
        $article->setUser($this->getAndVerifyUser($user->getId()));

        // Add the entity to the entity manager.
        $this->entityManager->persist($article);

        // Apply changes to database.
        $this->entityManager->flush();

        return $article;
    }
    
    public function viewAction()
    {
        return new viewModel([
            
        ]);
    }
    
    private function getAndVerifyTheme($id)
    {
        if ($id < 1) {
            $this->flashMessenger()->addErrorMessage("le thème n'est pas correcte");
            $this->redirect()->toRoute('add.articles');
        }

        // Find a user with such ID.
        $theme = $this->entityManager->getRepository(Theme::class)
                ->find($id);

        if ($theme == null) {
            $this->flashMessenger()->addErrorMessage("le theme n'est pas correcte");
            $this->redirect()->toRoute('add.articles');
        }
        
        return $theme;
    }
    
    private function getAndVerifyUser($id)
    {
        if ($id < 1) {
            $this->flashMessenger()->addErrorMessage("Problème avec l'utilisateur connecté");
            $this->redirect()->toRoute('list.themes');
        }

        // Find a user with such ID.
        $theme = $this->entityManager->getRepository(User::class)
                ->find($id);

        if ($theme == null) {
            $this->flashMessenger()->addErrorMessage("problème avec l'utilisateur connecté");
            $this->redirect()->toRoute('list.themes');
        }
        
        return $theme;
    }

}
