<?php

namespace Application\Service;

use Application\Entity\Bordero;
use Application\Entity\Colli;
use Application\Entity\Hub;
use Application\Entity\Partner;
use Application\Entity\Sendung;
use Application\IO\Bordero\Bordero128Const;
use Application\IO\Bordero\Bordero128Document;
use Application\IO\Bordero\Bordero128Reader;
use Application\IO\Bordero\Bordero128SatzF;
use Application\IO\Bordero\Bordero128SendungsElement;
use Application\IO\Bordero\BorderoFileImportResult;
use DateTime;
use SplFileObject;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Zend\Log\Logger;

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
        $this->logger->info("Import abgeschlossen " . __METHOD__ . " Neue Bordero-Dateien: " . $result->getCount() . " / Fehler: " . $result->getCountError() . " / Warnungen: " . $result->getCountWarning());

        return $result;
    }

    private function importPartnerBorderoFiles(Partner $partner, BorderoFileImportResult $result) {
        $finder = new Finder();
        $finder->in($partner->getBorderoImportPfad())->depth('==0')->files()->name($partner->getBorderoImportPattern());
        /* @var $fileInfo SplFileInfo */
        foreach ($finder as $fileInfo) {
            $foundFile = $this->entityManager->getRepository(Bordero::class)->findByImportDateiname($fileInfo->getFilename());
            if (count($foundFile) == 0) {
                $this->importPartnerBorderoFile($partner, $fileInfo, $result);
            }
        }
    }

    private function importPartnerBorderoFile(Partner $partner, SplFileInfo $fileInfo, BorderoFileImportResult $result) {
        /* @var $file SplFileObject */
        $file = $fileInfo->openFile();
        if (!$file->eof()) {
            $headerLine = $file->fgets();
            if ($headerLine) {
                $file->rewind();
                $borderoFormat = substr($headerLine, 0, 11);
                if (strcmp($borderoFormat, Bordero128Const::PACKAGE_HEADER) == 0) {
                    $this->importBorderoFile128($partner, $file, $result);
                    $this->entityManager->flush();
                } else if (strcmp($borderoFormat, "@@PHBORD512") == 0) {
                    $this->importBorderoFile512($partner, $file, $result);
                    $this->entityManager->flush();
                } else {
                    $result->incCountError();
                    $this->logger->err("Fehler " . __METHOD__ . ": Borderofile '" . $fileInfo->getFilename() . "' mit unbekanntem Bordero-Format: '" . $borderoFormat . "'");
                }
            } else {
                $result->incCountError();
                $this->logger->err("Fehler " . __METHOD__ . ": Borderofile '" . $fileInfo->getFilename() . "' kann erste Zeile nicht einlesen!");
            }
        } else {
            $result->incCountError();
            $this->logger->err("Fehler " . __METHOD__ . ": Borderofile '" . $fileInfo->getFilename() . "' ist leer!");
        }
        $file = null;
    }

    private function importBorderoFile128(Partner $partner, SplFileObject $file, BorderoFileImportResult $result) {
        $borderoReader = new Bordero128Reader($this->logger);

        /* @var $borderoDocument Bordero128Document */
        $borderoDocument = $borderoReader->readFile($file, $result);
        if ($borderoDocument) {
            $hub = $this->entityManager->getRepository(Hub::class)->findOneBy(['partner' => $partner->getInterneId(), 'kennung' => $borderoDocument->getHeader()->getVersandDepotKennung(), 'aktiv' => true]);
            if ($hub) {
                if (strcmp($borderoDocument->getHeader()->getEmpfangsDepotKennung(), $partner->getEigeneDepotKennung()) == 0) {
                    $bordero = new Bordero();
                    $bordero->setHub($hub);
                    $bordero->setZeitstempel(new \DateTime());
                    $bordero->setImportDateiname($file->getFilename());
                    $bordero->setNummer($borderoDocument->getSatzA()->getBorderoNummer());
                    $bordero->setDatum($borderoDocument->getSatzA()->getVersandDatum());
                    $bordero->setEmpfangsDepotKennung($borderoDocument->getHeader()->getEmpfangsDepotKennung());
                    $bordero->setReleaseKennung($borderoDocument->getSatzA()->getReleaseKennung());
                    $this->entityManager->persist($bordero);

                    /* @var $sendungsElement Bordero128SendungsElement */
                    foreach ($borderoDocument->getSendungen() as $sendungsElement) {
                        $sendung = new Sendung();
                        $sendung->setBordero($bordero);
                        $sendung->setZeitstempel(new \DateTime());
                        $sendung->setBorderoPosition($sendungsElement->getSatzB()->getPosition());
                        $sendung->setVersenderName1($sendungsElement->getSatzB()->getVersenderName1());
                        $sendung->setVersenderName2($sendungsElement->getSatzB()->getVersenderName2());
                        $sendung->setVersenderStrasse($sendungsElement->getSatzB()->getVersenderStrasse());
                        $sendung->setVersenderPlz($sendungsElement->getSatzB()->getVersenderPLZ());
                        $sendung->setVersenderOrt($sendungsElement->getSatzC()->getVersenderOrt());
                        $sendung->setVersenderLand($sendungsElement->getSatzB()->getVersenderLand());
                        $sendung->setEmpfaengerName1($sendungsElement->getSatzD()->getEmpfaengerName1());
                        $sendung->setEmpfaengerName2($sendungsElement->getSatzD()->getEmpfaengerName2());
                        $sendung->setEmpfaengerStrasse($sendungsElement->getSatzE()->getEmpfaengerStrasse());
                        $sendung->setEmpfaengerPlz($sendungsElement->getSatzE()->getEmpfaengerPLZ());
                        $sendung->setEmpfaengerOrt($sendungsElement->getSatzE()->getEmpfaengerOrt());
                        $sendung->setEmpfaengerLand($sendungsElement->getSatzE()->getEmpfaengerLand());
                        $sendung->setSendungsnummer($sendungsElement->getSatzFs()[0]->getSendungsnummer());
                        $sendung->setGewicht($sendungsElement->getSatzI() ? $sendungsElement->getSatzI()->getTatsaechlichesGewicht() : NULL);
                        $sendung->setHinweisText($sendungsElement->getSatzJ() ? $sendungsElement->getSatzJ()->getInfoFeld() : NULL);
                        $this->entityManager->persist($sendung);

                        $colliIndex = 0; //colli index in den H-Saetzen
                        /* @var $satzF Bordero128SatzF */
                        foreach ($sendungsElement->getSatzFs() as $satzF) {
                            $colliCount = $satzF->getAnzahlLademittel();
                            for ($i = 0; $i < $colliCount; $i++) {
                                if ($colliIndex >= count($sendungsElement->getSatzHs())) {
                                    $result->incCountWarning();
                                    $this->logger->warn("Warnung " . __METHOD__ . ": Borderofile '" . $file->getFilename() . "' Anzahl F-Packstuecke<>H-Packstuecke Position:" . $sendung->getBorderoPosition());
                                    break;
                                }
                                $colli = new Colli();
                                $colli->setSendung($sendung);
                                $colli->setZeitstempel(new \DateTime());
                                $colli->setBarcode($sendungsElement->getSatzHs()[$colliIndex]->getBarcode());
                                $colli->setAnzahlLademittel($colliCount);
                                $colli->setLademittelart($satzF->getLademittelArt());
                                $colli->setWareninhalt($satzF->getWareninhalt());
                                $this->entityManager->persist($colli);
                                $colliIndex++;
                            }
                        }
                    }

                    $result->incCount();
                } else {
                    $result->incCountError();
                    $this->logger->err("Fehler " . __METHOD__ . ": Borderofile '" . $file->getFilename() . "' mit ungueltiger E-Depot-Kennung: '" . $borderoDocument->getHeader()->getEmpfangsDepotKennung() . "'!");
                }
            } else {
                $result->incCountError();
                $this->logger->err("Fehler " . __METHOD__ . ": Borderofile '" . $file->getFilename() . "' mit nicht definierter HUB-Kennung: '" . $borderoDocument->getHeader()->getVersandDepotKennung() . "'!");
            }
        }
    }

    private function importBorderoFile512(Partner $partner, SplFileObject $file, BorderoFileImportResult $result) {
        $bordero = new Bordero();
        $bordero->setHub($partner->getHubs()[0]);
        $bordero->setZeitstempel(new DateTime());
        $bordero->setImportDateiname($file->getFilename());
        $bordero->setNummer("123");
        $bordero->setDatum(new DateTime("2019-01-31"));
        $bordero->setEmpfangsDepotKennung("096");
        $bordero->setReleaseKennung("512");
        $this->entityManager->persist($bordero);

        $result->incCount();
    }

}
