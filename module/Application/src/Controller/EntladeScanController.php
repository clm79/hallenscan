<?php

namespace Application\Controller;

use Application\Entity\Colli;
use Application\Entity\NvRelation;
use Application\Form\EntladeScanForm;
use Application\Util\Log\LogProcessor;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Helper\Placeholder\Container;
use Zend\View\Model\ViewModel;

class EntladeScanController extends AbstractActionController {

    public const SESSION_KEY_REQUEST_ID = "entladeScanRequestId";

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
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager, $sessionContainer/* , $borderoFileManager */) {
        $this->entityManager = $entityManager;
        $this->sessionContainer = $sessionContainer;
        //$this->borderoFileManager = $borderoFileManager;
    }

    public function indexAction() {
        return new ViewModel();
    }

    public function scanAction() {
        $form = new EntladeScanForm('Scan');

        // Check whether this post is a POST request.
        if ($this->getRequest()->isPost()) {
            // Get POST data.
            $data = $this->params()->fromPost();

            // Fill form with data.
            $form->setData($data);
            if ($form->isValid()) {
                $barcode = $form->getData()['barcode'];

                /* @var Colli $colli */
                $colli = $this->entityManager->getRepository(Colli::class)->findOneBy(['barcode' => $barcode], ['zeitstempel' => 'DESC']);
                if ($colli) {
                    
                }

                $this->sessionContainer[self::SESSION_KEY_REQUEST_ID] = LogProcessor::getRequestId();
                return $this->redirect()->toRoute('entlade-scan', ['action' => 'scan'], ['query' => ['barcode' => $barcode]]);
            }

            // Render the view template.
            return new ViewModel([
                'form' => $form,
                'messages' => $this->flashMessenger()->getMessages()
            ]);
        } else {
            $colli = null;
            $nvRelation = null;

            $barcode = isset($this->params()->fromQuery()['barcode']) ? $this->params()->fromQuery()['barcode'] : null;
            if ($barcode) {
                /* @var Colli $colli */
                $colli = $this->entityManager->getRepository(Colli::class)->findOneBy(['barcode' => $barcode], ['zeitstempel' => 'DESC']);

                if ($colli) {
                    /* @var Sendung $sendung */
                    $sendung = $colli->getSendung();

                    /* @var NvRelation $nvRelation */
                    $nvRelation = $this->entityManager->getRepository(NvRelation::class)->findOneBy(['land' => $sendung->getEmpfaengerLand(), 'plz' => $sendung->getEmpfaengerPlz()], ['zeitstempel' => 'DESC']);
                }
            }

            return new ViewModel([
                'form' => $form,
                'colli' => $colli,
                'nvRelation' => $nvRelation,
                'messages' => $this->flashMessenger()->getMessages()
            ]);
        }
    }

}
