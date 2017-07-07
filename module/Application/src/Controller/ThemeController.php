<?php

namespace Application\Controller;

use Application\Entity\Theme;
use Application\Form\ThemeForm;
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


    private $entityManager;
    /**
     * Constructs the controller.
     */
    public function __construct($entityManager, $authService, $sessionManager) {
        $this->entityManager = $entityManager;
        $this->authService = $authService;
        $this->sessionManager = $sessionManager;
    }

    public function indexAction()
    {
        $this->verifyRoleForUser(1);
        $themes = $this->entityManager->getRepository(Theme::class)
                ->findBy([], ['id' => 'ASC']);

        return new ViewModel([
            'themes' => $themes
        ]);
    }

    public function viewAction()
    {
        $this->verifyRoleForUser(1);
        $id = (int) $this->params()->fromRoute('id', -1);

        $theme = $this->getAndVerifyTheme($id);

        return new ViewModel([
            'theme' => $theme
        ]);
    }

    public function addAction()
    {
        $this->verifyRoleForUser(1);
        $form = new ThemeForm($this->entityManager);

        if ($this->getRequest()->isPost()) {

            $data = $this->params()->fromPost();

            $form->setData($data);

            if ($form->isValid()) {

                $data = $form->getData();

                $theme = new Theme();
                $theme->setName($data['name']);

                $this->entityManager->persist($theme);

                // Apply changes to database.
                $this->entityManager->flush();

                $this->flashMessenger()->addSuccessMessage("L'ajout du thème est une reussite");
                return $this->redirect()->toRoute('view.themes', ['id' => $theme->getId()]);
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    public function deleteAction()
    {
        $this->verifyRoleForUser(1);
        $id = (int) $this->params()->fromRoute('id', -1);

        $theme = $this->getAndVerifyTheme($id);

        $this->entityManager->remove($theme);

        // Apply changes to database.
        $this->entityManager->flush();

        $this->flashMessenger()->addSuccessMessage('Le thème a bien été supprimé');
        return $this->redirect()->toRoute('list.themes');

    }

    public function editAction()
    {
        $this->verifyRoleForUser(1);
        $id = (int) $this->params()->fromRoute('id', -1);

        $theme = $this->getAndVerifyTheme($id);

        $form = new ThemeForm($this->entityManager, $theme);

        if ($this->getRequest()->isPost()) {

            $data = $this->params()->fromPost();

            $form->setData($data);

            if ($form->isValid()) {

                $data = $form->getData();

                $theme->setName($data['name']);

                // Apply changes to database.
                $this->entityManager->flush();

                $this->flashMessenger()->addSuccessMessage('Le thème a bien été édité');
                return $this->redirect()->toRoute('list.themes');
            }
        } else {
            $form->setData(array(
                    'name'=>$theme->getName(),
                ));
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    private function getAndVerifyTheme($id)
    {
        if ($id < 1) {
            $this->flashMessenger()->addErrorMessage("l'id distribué n'est pas correcte");
            $this->redirect()->toRoute('list.themes');
        }

        // Find a user with such ID.
        $theme = $this->entityManager->getRepository(Theme::class)
                ->find($id);

        if ($theme == null) {
            $this->flashMessenger()->addErrorMessage("le thème n'existe pas");
            $this->redirect()->toRoute('list.themes');
        }

        return $theme;
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
