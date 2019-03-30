<?php

namespace Application\Service;

use Zend\Log\Logger;

class BorderoFileManager {

    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;
    
    /**
     *
     * @var Zend\Log\Logger
     */
    private $logger;

    // Constructor is used to inject dependencies into the service.
    public function __construct($entityManager, Logger $logger) {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    public function importBorderoFiles() {
        $this->logger->info("Finished ".__METHOD__);
    }
}
