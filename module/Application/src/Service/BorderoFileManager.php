<?php

namespace Application\Service;

use Zend\Log\Logger;
use Application\Entity\Partner;

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
        $partners = $this->entityManager->getRepository(Partner::class)->findByAktiv(true);
        foreach ($partners as $partner) {
            $this->importPartnerBorderoFiles($partner);
        }
        $this->logger->info("Finished ".__METHOD__);
    }
    
    private function importPartnerBorderoFiles(Partner $partner) {
        
    }
}
