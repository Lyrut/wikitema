<?php

namespace Application\Controller;

use Application\Entity\Article;
use Application\Entity\Theme;
use Application\Form\ArticleForm;
use Authentification\Entity\User;
use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\SessionManager;
use Zend\View\Model\JsonModel;
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
        
        $this->verifyRoleForUser(3);
        
        $articles = $this->entityManager->getRepository(Article::class)
                ->getLastArticles();

        return new ViewModel([
            'articles' => $articles
        ]);
    }

    public function addAction() {
        
        $this->verifyRoleForUser(2);
        
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

        $this->verifyRoleForUser(2);
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
        $this->verifyRoleForUser(3);
        $id = (int) $this->params()->fromRoute('id', -1);

        $article = $this->getAndVerifyArticle($id);
        $theme = $this->getAndVerifyTheme($article->getTheme()->getId());
        $user = $this->getAndVerifyUser($article->getUser()->getId());
        $user->setPassword('');
        
        return new viewModel([
            'article' => $article,
            'theme' => $theme,
            'creatorOfArticle' => $user
        ]);
    }
    
    public function editAction() {
        $themes = $this->entityManager->getRepository(Theme::class)
                ->findBy([], ['id' => 'ASC']);
        $t = [];
        foreach ($themes as $data) {
            $t[$data->getId()] = $data->getName();
        }
        $id = (int) $this->params()->fromRoute('id', -1);
        $article = $this->getAndVerifyArticle($id);
        // Create user form
        $form = new ArticleForm($t, $this->entityManager, $article);

        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {

            // Fill in the form with POST data
            $data = $this->params()->fromPost();

            $form->setData($data);

            // Validate form
            if ($form->isValid()) {

                // Get filtered and validated data
                $data = $form->getData();

                
                $article->setTitle($data['title']);
                $article->setText($data['text']);
                $article->setTheme($this->getAndVerifyTheme($data['theme']));
                
                 $this->entityManager->flush();

                // Redirect to "view" page
                return $this->redirect()->toRoute('view.articles', ['id' => $article->getId()]);
            }

        }else{
            $form->setData(array(
                    'title'=>$article->getTitle(),
                    'text'=>$article->getText(),
                    'theme'=>$article->getTheme()->getId(),
                ));
        }
        return new ViewModel([
            'form' => $form
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
            $this->flashMessenger()->addErrorMessage("le thème n'est pas correcte");
            $this->redirect()->toRoute('add.articles');
        }

        return $theme;
    }

    private function getAndVerifyUser($id)
    {
        if ($id < 1) {
            $this->flashMessenger()->addErrorMessage("Problème avec l'utilisateur connecté");
            $this->redirect()->toRoute('add.articles');
        }

        // Find a user with such ID.
        $user = $this->entityManager->getRepository(User::class)
                ->find($id);

        if ($user == null) {
            $this->flashMessenger()->addErrorMessage("Problème avec l'utilisateur connecté");
            $this->redirect()->toRoute('add.articles');
        }

        return $user;
    }

    private function getAndVerifyArticle($id)
    {
        if ($id < 1) {
            $this->flashMessenger()->addErrorMessage("L'id distribué n'est pas correcte");
            $this->redirect()->toRoute('index.articles');
        }

        // Find a user with such ID.
        $article = $this->entityManager->getRepository(Article::class)
                ->find($id);

        if ($article == null) {
            $this->flashMessenger()->addErrorMessage("L'utilisateur n'existe pas");
            $this->redirect()->toRoute('index.articles');
        }

        return $article;
    }
    
    public function listJsonAction()
    {
        $this->verifyRoleForUser(3);
        $articles = $this->entityManager->getRepository(Article::class)->getAllArticles();
        
        $list = [];
        foreach ($articles as $article) {
            $list[$article->getId()] = $article->getTitle();
        }
        
        return new JsonModel($list);
    }
    
    public function redirectAutocompleteAction()
    {
        $this->verifyRoleForUser(3);
        $article_title = $this->params()->fromQuery('title');
        
        //$article = $this->entityManager->getRepository(Article::class)->findOneByTitle($article_title);
        $article = $this->entityManager->getRepository(Article::class)->getArticleByTitle($article_title);
        
        if (!$article) {
            $this->flashMessenger()->addErrorMessage("L'utilisateur n'existe pas");
            $this->redirect()->toRoute('index.articles');
        }
        
        $this->redirect()->toRoute('view.articles', ['id'=>$article[0]->getId()]);
    }
    
    private function verifyRoleForUser($level_of_access)
    {
        $user = $this->authService->getIdentity();
        if(!$user) {
            $this->flashMessenger()->addErrorMessage("Vous n'avez pas accès à cette page");
            $this->redirect()->toRoute('connexion');
        }
        if($level_of_access >= $user->getRole())
        {
            $this->flashMessenger()->addErrorMessage("Vous n'avez pas accès à cette page");
            $this->redirect()->toRoute('connexion');
        }
    }

}
