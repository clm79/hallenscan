<?php

namespace Application\Service;

class BorderoFileManager {

    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    // Constructor is used to inject dependencies into the service.
    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

    public function importBorderoFiles() {
        
    }
}
