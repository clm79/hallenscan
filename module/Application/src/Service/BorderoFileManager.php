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
use Application\IO\Bordero\Bordero512Const;
use Application\IO\Bordero\Bordero512Document;
use Application\IO\Bordero\Bordero512Reader;
use Application\IO\Bordero\Bordero512SendungsElement;
use Application\IO\Bordero\BorderoFileImportResult;
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
        $this->logger->info("Import abgeschlossen. Neue Bordero-Dateien: " . $result->getCount() . " / Fehler: " . $result->getCountError() . " / Warnungen: " . $result->getCountWarning(), ["classMethod" => __METHOD__]);

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
                } else if (strcmp($borderoFormat, Bordero512Const::PACKAGE_HEADER) == 0) {
                    $this->importBorderoFile512($partner, $file, $result);
                    $this->entityManager->flush();
                } else {
                    $result->incCountError();
                    $this->logger->err("Borderofile '" . $fileInfo->getFilename() . "' mit unbekanntem Bordero-Format: '" . $borderoFormat . "'", ["classMethod" => __METHOD__]);
                }
            } else {
                $result->incCountError();
                $this->logger->err("Borderofile '" . $fileInfo->getFilename() . "' kann erste Zeile nicht einlesen!", ["classMethod" => __METHOD__]);
            }
        } else {
            $result->incCountError();
            $this->logger->err("Borderofile '" . $fileInfo->getFilename() . "' ist leer!", ["classMethod" => __METHOD__]);
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
                                    $this->logger->warn("Borderofile '" . $file->getFilename() . "' Anzahl F-Packstuecke<>H-Packstuecke Position:" . $sendung->getBorderoPosition(), ["classMethod" => __METHOD__]);
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
                    $this->logger->err("Borderofile '" . $file->getFilename() . "' mit ungueltiger E-Depot-Kennung: '" . $borderoDocument->getHeader()->getEmpfangsDepotKennung() . "'!", ["classMethod" => __METHOD__]);
                }
            } else {
                $result->incCountError();
                $this->logger->err("Borderofile '" . $file->getFilename() . "' mit nicht definierter HUB-Kennung: '" . $borderoDocument->getHeader()->getVersandDepotKennung() . "'!", ["classMethod" => __METHOD__]);
            }
        }
    }

    private function importBorderoFile512(Partner $partner, SplFileObject $file, BorderoFileImportResult $result) {
        $borderoReader = new Bordero512Reader($this->logger);

        /* @var $borderoDocument Bordero512Document */
        $borderoDocument = $borderoReader->readFile($file, $result);
        if ($borderoDocument) {
            $hub = $this->entityManager->getRepository(Hub::class)->findOneBy(['partner' => $partner->getInterneId(), 'kennung' => $borderoDocument->getHeader()->getVersandDepotKennung(), 'aktiv' => true]);
            if ($hub) {
                if (strcmp($borderoDocument->getHeader()->getEmpfangsDepotKennung(), $partner->getEigeneDepotKennung()) == 0) {
                    $bordero = new Bordero();
                    $bordero->setHub($hub);
                    $bordero->setZeitstempel(new \DateTime());
                    $bordero->setImportDateiname($file->getFilename());
                    $bordero->setNummer($borderoDocument->getSatzA00()->getBorderoNummer());
                    $bordero->setDatum($borderoDocument->getSatzA00()->getBorderoDatum());
                    $bordero->setEmpfangsDepotKennung($borderoDocument->getHeader()->getEmpfangsDepotKennung());
                    $bordero->setReleaseKennung($borderoDocument->getSatzA00()->getReleaseKennung());
                    $this->entityManager->persist($bordero);

                    /* @var $sendungsElement Bordero512SendungsElement */
                    foreach ($borderoDocument->getSendungen() as $sendungsElement) {
                        $sendung = new Sendung();
                        $sendung->setBordero($bordero);
                        $sendung->setZeitstempel(new \DateTime());
                        $sendung->setBorderoPosition($sendungsElement->getSatzG00()->getPosition());

                        $shpB00 = $sendungsElement->getSatzB00ByAdressArt(Bordero512Const::ADRESS_ART_VERSENDER);
                        if (is_null($shpB00)) {
                            $result->incCountWarning();
                            $this->logger->warn("Borderofile '" . $file->getFilename() . "' Sendung ohne Absender! Position:" . $sendung->getBorderoPosition(), ["classMethod" => __METHOD__]);
                            continue;
                        }
                        $conB00 = $sendungsElement->getSatzB00ByAdressArt(Bordero512Const::ADRESS_ART_EMPFAENGER);
                        if (is_null($conB00)) {
                            $result->incCountWarning();
                            $this->logger->warn("Borderofile '" . $file->getFilename() . "' Sendung ohne Empfaenger! Position:" . $sendung->getBorderoPosition(), ["classMethod" => __METHOD__]);
                            continue;
                        }

                        $sendung->setVersenderName1($shpB00->getName1());
                        $sendung->setVersenderName2($shpB00->getName2());
                        $sendung->setVersenderStrasse($shpB00->getStrasse());
                        $sendung->setVersenderPlz($shpB00->getPlz());
                        $sendung->setVersenderOrt($shpB00->getOrt());
                        $sendung->setVersenderLand($shpB00->getLand());
                        $sendung->setEmpfaengerName1($conB00->getName1());
                        $sendung->setEmpfaengerName2($conB00->getName2());
                        $sendung->setEmpfaengerStrasse($conB00->getStrasse());
                        $sendung->setEmpfaengerPlz($conB00->getPlz());
                        $sendung->setEmpfaengerOrt($conB00->getOrt());
                        $sendung->setEmpfaengerLand($conB00->getLand());
                        $sendung->setSendungsnummer($sendungsElement->getSatzG00()->getSendungsNummer());
                        $sendung->setGewicht(round($sendungsElement->getSatzG00()->getTatsaechlichesGewicht()));
                        $hinweisText = NULL;
                        if($sendungsElement->getSatzH10()) {
                            $h10 = $sendungsElement->getSatzH10();
                            $hinweisText = $h10->getFreierText1();
                            if($h10->getFreierText2()) $hinweisText .= $h10->getFreierText2 ();
                            if($h10->getFreierText3()) $hinweisText .= $h10->getFreierText3 ();
                        }
                        $sendung->setHinweisText($hinweisText);
                        $this->entityManager->persist($sendung);
                    }

                    $result->incCount();
                } else {
                    $result->incCountError();
                    $this->logger->err("Borderofile '" . $file->getFilename() . "' mit ungueltiger E-Depot-Kennung: '" . $borderoDocument->getHeader()->getEmpfangsDepotKennung() . "'!", ["classMethod" => __METHOD__]);
                }
            } else {
                $result->incCountError();
                $this->logger->err("Borderofile '" . $file->getFilename() . "' mit nicht definierter HUB-Kennung: '" . $borderoDocument->getHeader()->getVersandDepotKennung() . "'!", ["classMethod" => __METHOD__]);
            }
        }
    }

}
