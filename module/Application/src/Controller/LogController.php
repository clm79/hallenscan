<?php

namespace Application\Controller;

use Application\Entity\ZendLog;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LogController extends AbstractActionController {
    public const MAX_LIMIT = 100;
    
    /**
     * Entity manager.
     * @var EntityManager 
     */
    private $entityManager;

    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

    public function indexAction() {
        return new ViewModel();
    }

    public function listAction() {
        $requestId = (string) $this->params()->fromQuery("requestId");
        if (!$requestId) {
            $logs = $this->entityManager->getRepository(ZendLog::class)->findBy([], ['timestamp' => 'DESC'], self::MAX_LIMIT);
        } else {
            $logs = $this->entityManager->getRepository(ZendLog::class)->findBy(['extraRequestId' => $requestId], ['timestamp' => 'DESC'], self::MAX_LIMIT);
        }

        return new ViewModel([
            'logs' => $logs,
        ]);
    }

}
