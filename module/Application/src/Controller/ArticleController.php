<?php
namespace Application\Controller;

use Application\Entity\Article;
use Application\Form\ArticleForm;
use Doctrine\ORM\EntityManager;
use Exception;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ArticleController extends AbstractActionController
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

    public function viewAction()
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->flashMessenger()->addErrorMessage("l'id distribué n'est pas correcte");
            $this->redirect()->toRoute('list.articles');
        }
        
        // Find a article with such ID.
        $article = $this->entityManager->getRepository(Article::class)
                ->find($id);
        
        if ($article == null) {
            $this->flashMessenger()->addErrorMessage("l'article n'existe pas");
            $this->redirect()->toRoute('list.theme');
        }
                
        return new ViewModel([
            'article' => $article
        ]);
    }
    public function addAction()
    {
        // Create article form
        $form = new ArticleForm('create', $this->entityManager);
        
        // Check if article has submitted the form
        if ($this->getRequest()->isPost()) {
            
            // Fill in the form with POST data
            $data = $this->params()->fromPost();            
            
            $form->setData($data);
            
            // Validate form
            if($form->isValid()) {
                
                // Get filtered and validated data
                $data = $form->getData();
                
                
                // Add article.
                $article = $this->addArticle($data);
                
                // Redirect to "view" page
                return $this->redirect()->toRoute('view.article', 
                        ['id'=>$article->getId()]);                
            }               
        } 
        
        return new ViewModel([
                'form' => $form
            ]);
    }
    
    private function addArticle($data) 
    {
                
        // Create new Article entity.
        $article = new Article();
        $article->setTheme($data['theme']);
        $article->setTitle($data['title']);
        $article->setText($data['text']);
        $article->setUser($data['user']);
        
        $currentDate = date('Y-m-d H:i:s');
        $article->setDateCreated($currentDate);        
                
        // Add the entity to the entity manager.
        $this->entityManager->persist($article);
        
        // Apply changes to database.
        $this->entityManager->flush();
        
        return $article;
    }
    }