<?php

namespace Application\Service;

use Zend\Log\Logger;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Application\Entity\Partner;
use Application\Entity\Hub;
use Application\Entity\Bordero;
use Doctrine\ORM\EntityManager;

class BorderoFileManager {

    /**
     * Doctrine entity manager.
     * @var $entityManager Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     *
     * @var $logger Zend\Log\Logger
     */
    private $logger;

    // Constructor is used to inject dependencies into the service.
    public function __construct($entityManager, Logger $logger) {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    public function importBorderoFiles(): BorderoFileImportResult {
        $result = new BorderoFileImportResult();

        $partners = $this->entityManager->getRepository(Partner::class)->findByAktiv(true);
        foreach ($partners as $partner) {
            $this->importPartnerBorderoFiles($partner, $result);
        }
        $this->entityManager->flush();
        $this->logger->info("Import abgeschlossen " . __METHOD__);

        return $result;
    }

    private function importPartnerBorderoFiles(Partner $partner, BorderoFileImportResult $result) {
        $finder = new Finder();
        $finder->in($partner->getBorderoImportPfad())->depth('==0')->files()->name($partner->getBorderoImportPattern());
        /* @var $fileInfo SplFileInfo */
        foreach ($finder as $fileInfo) {
            //$pathname = $fileInfo->getPathname();
            //$this->logger->debug($partner->getName().': '.$pathname);
            //$result->incCount();
            $foundFile = $this->entityManager->getRepository(Bordero::class)->findByImportDateiname($fileInfo->getFilename());
            if (count($foundFile) == 0) {
                $this->importPartnerBorderoFile($partner, $fileInfo, $result);
            }
        }
    }

    private function importPartnerBorderoFile(Partner $partner, SplFileInfo $fileInfo, BorderoFileImportResult $result) {
        /* @var $file \SplFileObject */
        $file = $fileInfo->openFile();
        if (!$file->eof()) {
            $headerLine = $file->fgets();
            if ($headerLine) {
                $borderoFormat = substr($headerLine, 0, 11);
                if (strcmp($borderoFormat, "@@PHBORD128") == 0) {
                    $this->importBorderoFile128($partner, $file, $headerLine, $result);
                } else if (strcmp($borderoFormat, "@@PHBORD512") == 0) {
                    $this->importBorderoFile512($partner, $file, $headerLine, $result);
                } else {
                    $result->incCountError();
                    $this->logger->warn("Fehler " . __METHOD__ . ": Borderofile '" . $fileInfo->getFilename() . "' mit unbekanntem Bordero-Format: '" . $borderoFormat . "'");
                }
            } else {
                $result->incCountError();
                $this->logger->warn("Fehler " . __METHOD__ . ": Borderofile '" . $fileInfo->getFilename() . "' kann erste Zeile nicht einlesen!");
            }
        } else {
            $result->incCountError();
            $this->logger->warn("Fehler " . __METHOD__ . ": Borderofile '" . $fileInfo->getFilename() . "' ist leer!");
        }
        $file = null;
    }

    private function importBorderoFile128(Partner $partner, \SplFileObject $file, string $headerLine, BorderoFileImportResult $result) {
        $hubKennung = substr($headerLine, 50 - 1, 3);
        $empfangsDepotKennung = substr($headerLine, 58 - 1, 3);

        $hub = $this->entityManager->getRepository(Hub::class)->findOneBy(['partner' => $partner->getInterneId(), 'kennung' => $hubKennung, 'aktiv' => true]);
        if ($hub) {
            if (strcmp($empfangsDepotKennung, $partner->getEigeneDepotKennung()) == 0) {
                $bordero = new Bordero();
                $bordero->setHub($hub);
                $bordero->setZeitstempel(new \DateTime());
                $bordero->setImportDateiname($file->getFilename());
                $bordero->setNummer("123");
                $bordero->setDatum(new \DateTime("2019-01-31"));
                $bordero->setEmpfangsDepotKennung($empfangsDepotKennung);
                $bordero->setReleaseKennung("128");
                $this->entityManager->persist($bordero);

                $result->incCount();
            } else {
                $result->incCountError();
                $this->logger->warn("Fehler " . __METHOD__ . ": Borderofile '" . $file->getFilename() . "' mit ungueltiger E-Depot-Kennung: '" . $empfangsDepotKennung . "'!");
            }
        } else {
            $result->incCountError();
            $this->logger->warn("Fehler " . __METHOD__ . ": Borderofile '" . $file->getFilename() . "' mit nicht definierter HUB-Kennung: '" . $hubKennung . "'!");
        }
    }

    private function importBorderoFile512(Partner $partner, \SplFileObject $file, string $headerLine, BorderoFileImportResult $result) {
        $bordero = new Bordero();
        $bordero->setHub($partner->getHubs()[0]);
        $bordero->setZeitstempel(new \DateTime());
        $bordero->setImportDateiname($file->getFilename());
        $bordero->setNummer("123");
        $bordero->setDatum(new \DateTime("2019-01-31"));
        $bordero->setEmpfangsDepotKennung("096");
        $bordero->setReleaseKennung("512");
        $this->entityManager->persist($bordero);

        $result->incCount();
    }

}
