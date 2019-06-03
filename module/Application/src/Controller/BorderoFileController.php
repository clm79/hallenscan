<?php

namespace Application\Controller;

use Application\Entity\Partner;
use Application\Form\GenericSubmitForm;
use Application\IO\Bordero\BorderoFileImportResult;
use Application\Service\BorderoFileManager;
use Application\Util\Log\LogProcessor;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class BorderoFileController extends AbstractActionController {

    public const SESSION_KEY_REQUEST_ID = "borderoFileImportRequestId";
    
    /**
     * Entity manager.
     * @var EntityManager 
     */
    private $entityManager;

    /**
     * Session container.
     * @var Container
     */
    private $sessionContainer;

    /**
     * Manager.
     * @var BorderoFileManager 
     */
    private $borderoFileManager;

    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager, $sessionContainer, $borderoFileManager) {
        $this->entityManager = $entityManager;
        $this->sessionContainer = $sessionContainer;
        $this->borderoFileManager = $borderoFileManager;
    }

    public function indexAction() {
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

                /* @var $result BorderoFileImportResult */
                $result = $this->borderoFileManager->importBorderoFiles();

                $this->flashMessenger()->addMessage($result->getCount() . ' neue Bordero-Datei(en) importiert.');
                $this->flashMessenger()->addMessage($result->getCountError() . ' Fehler beim Import aufgetreten.');
                $this->flashMessenger()->addMessage($result->getCountWarning() . ' Warnung(en) beim Import aufgetreten.');

                $this->sessionContainer[self::SESSION_KEY_REQUEST_ID] = LogProcessor::getRequestId();

                return $this->redirect()->toRoute('bordero-file', ['action' => 'import']);
            }
            // Render the view template.
            return new ViewModel([
                'form' => $form,
                'messages' => $this->flashMessenger()->getMessages()
            ]);
        } else {
            $partners = $this->entityManager->getRepository(Partner::class)->findAll();

            // Render the view template.
            return new ViewModel([
                'partners' => $partners,
                'form' => $form,
                'messages' => $this->flashMessenger()->getMessages()
            ]);
        }
    }

}
