<?php

namespace Application\IO\Bordero;

use DateTime;
use SplFileObject;
use Zend\Log\Logger;

/**
 * Description of Bordero128Reader
 *
 * @author cmartin
 */
class Bordero128Reader {
    /* @var Logger */

    private $logger;

    public function __construct(Logger $logger) {
        $this->logger = $logger;
    }

    public function readFile(SplFileObject $file, BorderoFileImportResult $result): ?Bordero128Document {
        $document = new Bordero128Document();
        $currentLineNumber = 1;

        $headerLine = $file->fgets();
        if (!$headerLine) {
            $result->incCountError();
            $this->logger->err("Borderofile '" . $file->getFilename() . "' kann Header nicht einlesen (Zeile " . $currentLineNumber . ")!", ["classMethod"=>__METHOD__]);
            return NULL;
        }

        $header = new Bordero128Header();
        $header->setPackageId(self::parseString(substr($headerLine, 1 - 1, 11)));
        $header->setVersandDepotKennung(self::parseString(substr($headerLine, 50 - 1, 3)));
        $header->setEmpfangsDepotKennung(self::parseString(substr($headerLine, 58 - 1, 3)));
        $document->setHeader($header);
        $currentLineNumber++;
        
        while (!$file->eof()) {
            $satzLine = $file->fgets();
            if ($satzLine) {
                $satzart = self::parseString(substr($satzLine, 0, 1));
                if (!$satzart) {
                    $result->incCountError();
                    $this->logger->err("Borderofile '" . $file->getFilename() . "' kann Satz-Art nicht ermitteln (Zeile " . $currentLineNumber . ")!", ["classMethod"=>__METHOD__]);
                    return NULL;
                }

                if (strcmp($satzart, Bordero128SatzA::SATZART) == 0) {
                    $satz = $this->parseLineSatzA($satzLine);
                    if (!$satz) {
                        $result->incCountError();
                        $this->logger->err("Borderofile '" . $file->getFilename() . "' kann A-Satz nicht verarbeiten (Zeile " . $currentLineNumber . ")!", ["classMethod"=>__METHOD__]);
                        return NULL;
                    }
                    $document->setSatzA($satz);
                } else if (strcmp($satzart, Bordero128SatzB::SATZART) == 0) {
                    $satz = $this->parseLineSatzB($satzLine);
                    if (!$satz) {
                        $result->incCountError();
                        $this->logger->err("Borderofile '" . $file->getFilename() . "' kann B-Satz nicht verarbeiten (Zeile " . $currentLineNumber . ")!", ["classMethod"=>__METHOD__]);
                        return NULL;
                    }
                    // neues Sendungs-Element anlegen
                    $sendung = new Bordero128SendungsElement();
                    $document->addSendung($sendung);
                    $sendung->setSatzB($satz);
                } else if (strcmp($satzart, Bordero128SatzC::SATZART) == 0) {
                    $satz = $this->parseLineSatzC($satzLine);
                    if (!$satz) {
                        $result->incCountError();
                        $this->logger->err("Borderofile '" . $file->getFilename() . "' kann C-Satz nicht verarbeiten (Zeile " . $currentLineNumber . ")!", ["classMethod"=>__METHOD__]);
                        return NULL;
                    }
                    $sendung->setSatzC($satz);
                } else if (strcmp($satzart, Bordero128SatzD::SATZART) == 0) {
                    $satz = $this->parseLineSatzD($satzLine);
                    if (!$satz) {
                        $result->incCountError();
                        $this->logger->err("Borderofile '" . $file->getFilename() . "' kann D-Satz nicht verarbeiten (Zeile " . $currentLineNumber . ")!", ["classMethod"=>__METHOD__]);
                        return NULL;
                    }
                    $sendung->setSatzD($satz);
                } else if (strcmp($satzart, Bordero128SatzE::SATZART) == 0) {
                    $satz = $this->parseLineSatzE($satzLine);
                    if (!$satz) {
                        $result->incCountError();
                        $this->logger->err("Borderofile '" . $file->getFilename() . "' kann E-Satz nicht verarbeiten (Zeile " . $currentLineNumber . ")!", ["classMethod"=>__METHOD__]);
                        return NULL;
                    }
                    $sendung->setSatzE($satz);
                } else if (strcmp($satzart, Bordero128SatzF::SATZART) == 0) {
                    $satz = $this->parseLineSatzF($satzLine);
                    if (!$satz) {
                        $result->incCountError();
                        $this->logger->err("Borderofile '" . $file->getFilename() . "' kann F-Satz nicht verarbeiten (Zeile " . $currentLineNumber . ")!", ["classMethod"=>__METHOD__]);
                        return NULL;
                    }
                    $sendung->addSatzF($satz);
                } else if (strcmp($satzart, Bordero128SatzH::SATZART) == 0) {
                    $satz = $this->parseLineSatzH($satzLine);
                    if (!$satz) {
                        $result->incCountError();
                        $this->logger->err("Borderofile '" . $file->getFilename() . "' kann H-Satz nicht verarbeiten (Zeile " . $currentLineNumber . ")!", ["classMethod"=>__METHOD__]);
                        return NULL;
                    }
                    $sendung->addSatzH($satz);
                } else if (strcmp($satzart, Bordero128SatzI::SATZART) == 0) {
                    $satz = $this->parseLineSatzI($satzLine);
                    if (!$satz) {
                        $result->incCountError();
                        $this->logger->err("Borderofile '" . $file->getFilename() . "' kann I-Satz nicht verarbeiten (Zeile " . $currentLineNumber . ")!", ["classMethod"=>__METHOD__]);
                        return NULL;
                    }
                    $sendung->setSatzI($satz);
                } else if (strcmp($satzart, Bordero128SatzJ::SATZART) == 0) {
                    $satz = $this->parseLineSatzJ($satzLine);
                    if (!$satz) {
                        $result->incCountError();
                        $this->logger->err("Borderofile '" . $file->getFilename() . "' kann J-Satz nicht verarbeiten (Zeile " . $currentLineNumber . ")!", ["classMethod"=>__METHOD__]);
                        return NULL;
                    }
                    $sendung->setSatzJ($satz);
                }

                $currentLineNumber++;
            }
        }

        return $document;
    }

    private static function parseLineSatzA(string $line): ?Bordero128SatzA {
        $satz = new Bordero128SatzA();
        $satz->setBorderoNummer(self::parseString(substr($line, 5 - 1, 14)));
        $satz->setVersandDatum(self::parseDate(substr($line, 23 - 1, 8)));
        $satz->setReleaseKennung(self::parseString(substr($line, 128 - 1, 1)));
        return $satz;
    }

    private static function parseLineSatzB(string $line): ?Bordero128SatzB {
        $satz = new Bordero128SatzB(self::parseInt(substr($line, 2 - 1, 3)));
        $satz->setVersenderName1(self::parseString(substr($line, 5 - 1, 35)));
        $satz->setVersenderName2(self::parseString(substr($line, 40 - 1, 35)));
        $satz->setVersenderStrasse(self::parseString(substr($line, 75 - 1, 35)));
        $satz->setVersenderLand(self::parseString(substr($line, 110 - 1, 3)));
        $satz->setVersenderPLZ(self::parseString(substr($line, 113 - 1, 9)));
        return $satz;
    }

    private static function parseLineSatzC(string $line): ?Bordero128SatzC {
        $satz = new Bordero128SatzC(self::parseInt(substr($line, 2 - 1, 3)));
        $satz->setVersenderOrt(self::parseString(substr($line, 5 - 1, 35)));
        return $satz;
    }

    private static function parseLineSatzD(string $line): ?Bordero128SatzD {
        $satz = new Bordero128SatzD(self::parseInt(substr($line, 2 - 1, 3)));
        $satz->setEmpfaengerName1(self::parseString(substr($line, 5 - 1, 35)));
        $satz->setEmpfaengerName2(self::parseString(substr($line, 40 - 1, 35)));
        return $satz;
    }

    private static function parseLineSatzE(string $line): ?Bordero128SatzE {
        $satz = new Bordero128SatzE(self::parseInt(substr($line, 2 - 1, 3)));
        $satz->setEmpfaengerStrasse(self::parseString(substr($line, 5 - 1, 35)));
        $satz->setEmpfaengerLand(self::parseString(substr($line, 40 - 1, 3)));
        $satz->setEmpfaengerPLZ(self::parseString(substr($line, 43 - 1, 9)));
        $satz->setEmpfaengerOrt(self::parseString(substr($line, 52 - 1, 35)));
        return $satz;
    }

    private static function parseLineSatzF(string $line): ?Bordero128SatzF {
        $satz = new Bordero128SatzF(self::parseInt(substr($line, 2 - 1, 3)));
        $satz->setAnzahlLademittel(self::parseInt(substr($line, 5 - 1, 4)));
        $satz->setLademittelArt(self::parseString(substr($line, 9 - 1, 2)));
        $satz->setWareninhalt(self::parseString(substr($line, 17 - 1, 20)));
        $satz->setSendungsnummer(self::parseString(substr($line, 37 - 1, 20)));
        return $satz;
    }
    
    private static function parseLineSatzH(string $line): ?Bordero128SatzH {
        $satz = new Bordero128SatzH(self::parseInt(substr($line, 2 - 1, 3)));
        $satz->setBarcode(self::parseString(substr($line, 8 - 1, 20)));
        return $satz;
    }

    private static function parseLineSatzI(string $line): ?Bordero128SatzI {
        $satz = new Bordero128SatzI(self::parseInt(substr($line, 2 - 1, 3)));
        $satz->setTatsaechlichesGewicht(self::parseInt(substr($line, 21 - 1, 5)));
        return $satz;
    }

    private static function parseLineSatzJ(string $line): ?Bordero128SatzJ {
        $satz = new Bordero128SatzJ(self::parseInt(substr($line, 2 - 1, 3)));
        $satz->setInfoFeld(self::parseString(substr($line, 5 - 1, 30)));
        return $satz;
    }
    
    private static function parseString(?string $field): ?string {
        if (!$field)
            return NULL;

        $fieldTrimmed = trim($field);
        if (strlen($fieldTrimmed) < 1)
            return NULL;

        return $fieldTrimmed;
    }

    private static function parseInt(?string $field): ?int {
        $parsedField = self::parseString($field);
        if (!$parsedField)
            return NULL;

        return (int) $parsedField;
    }

    private static function parseDate(?string $field): ?DateTime {
        $parsedField = self::parseString($field);
        if (!$parsedField)
            return NULL;

        $tag = substr($parsedField, 0, 2);
        $monat = substr($parsedField, 2, 2);
        $jahr = substr($parsedField, 4, 4);
        return new DateTime($jahr . "-" . $monat . "-" . $tag);
    }

}
