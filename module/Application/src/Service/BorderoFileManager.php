<?php

namespace Application\Service;

use Zend\Log\Logger;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
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

    public function importBorderoFiles() : BorderoFileImportResult {
        $result = new BorderoFileImportResult();
        
        $partners = $this->entityManager->getRepository(Partner::class)->findByAktiv(true);
        foreach ($partners as $partner) {
            $this->importPartnerBorderoFiles($partner, $result);
        }
        $this->logger->info("Finished " . __METHOD__);
        
        return $result;
    }

    private function importPartnerBorderoFiles(Partner $partner, BorderoFileImportResult $result) {
        $finder = new Finder();
        $finder->in($partner->getBorderoImportPfad())->depth('==0')->files()->name($partner->getBorderoImportPattern());
        /* @var $file SplFileInfo */
        foreach($finder as $file) {
            $pathname = $file->getPathname();
            //$this->logger->debug($partner->getName().': '.$pathname);
            $result->inc();
        }
    }

}
