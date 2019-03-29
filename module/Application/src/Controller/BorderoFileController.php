<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\GenericSubmitForm;

class BorderoFileController extends AbstractActionController {

    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager 
     */
    private $entityManager;

    /**
     * Manager.
     * @var Application\Service\BorderoFileManager 
     */
    private $borderoFileManager;

    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager, $borderoFileManager) {
        $this->entityManager = $entityManager;
        $this->borderoFileManager = $borderoFileManager;
    }

    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function importAction() {
        $form = new GenericSubmitForm('Einlesen');

        // Check whether this post is a POST request.
        if ($this->getRequest()->isPost()) {

            // Get POST data.
            $data = $this->params()->fromPost();

            // Fill form with data.
            $form->setData($data);
            if ($form->isValid()) {
                // Get validated form data.
                //$data = $form->getData();
                $this->borderoFileManager->importBorderoFiles();

                // Redirect the user to "index" page.
                return $this->redirect()->toRoute('bordero-file');
            }
        }

        // Render the view template.
        return new ViewModel([
            'form' => $form
        ]);
    }

}
