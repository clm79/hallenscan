<?php

namespace Application\IO\Bordero;

use DateTime;
use SplFileObject;
use Zend\Log\Logger;

/**
 * Description of Bordero512Reader
 *
 * @author cmartin
 */
class Bordero512Reader {
    /* @var Logger */

    private $logger;

    public function __construct(Logger $logger) {
        $this->logger = $logger;
    }
    
    public function readFile(SplFileObject $file, BorderoFileImportResult $result): ?Bordero512Document {
        $document = new Bordero512Document();
        $currentLineNumber = 1;

        $headerLine = $file->fgets();
        if (!$headerLine) {
            $result->incCountError();
            $this->logger->err("Borderofile '" . $file->getFilename() . "' kann Header nicht einlesen (Zeile " . $currentLineNumber . ")!", ["classMethod"=>__METHOD__]);
            return NULL;
        }

        $header = new Bordero512Header();
        $header->setPackageId(self::parseString(substr($headerLine, 1 - 1, 11)));
        $header->setVersandDepotKennung(self::parseString(substr($headerLine, 27 - 1, 5)));
        $header->setEmpfangsDepotKennung(self::parseString(substr($headerLine, 35 - 1, 5)));
        $document->setHeader($header);
        $currentLineNumber++;
        
        while (!$file->eof()) {
            $satzLine = $file->fgets();
            if ($satzLine) {
                $satzart = self::parseString(substr($satzLine, 0, 3));
                if (!$satzart) {
                    $result->incCountError();
                    $this->logger->err("Borderofile '" . $file->getFilename() . "' kann Satz-Art nicht ermitteln (Zeile " . $currentLineNumber . ")!", ["classMethod"=>__METHOD__]);
                    return NULL;
                }

                if (strcmp($satzart, Bordero512SatzA00::SATZART) == 0) {
                    $satz = $this->parseLineSatzA00($satzLine);
                    if (!$satz) {
                        $result->incCountError();
                        $this->logger->err("Borderofile '" . $file->getFilename() . "' kann A00-Satz nicht verarbeiten (Zeile " . $currentLineNumber . ")!", ["classMethod"=>__METHOD__]);
                        return NULL;
                    }
                    $document->setSatzA00($satz);
                } else if (strcmp($satzart, Bordero512SatzB00::SATZART) == 0) {
                    $satz = $this->parseLineSatzB00($satzLine);
                    if (!$satz) {
                        $result->incCountError();
                        $this->logger->err("Borderofile '" . $file->getFilename() . "' kann B00-Satz nicht verarbeiten (Zeile " . $currentLineNumber . ")!", ["classMethod"=>__METHOD__]);
                        return NULL;
                    }
                    
                    if(strcmp($satz->getAdressArt(), Bordero512Const::ADRESS_ART_VERSENDER)==0) {
                        //neues Sendungs-Element anlegen
                        $sendung = new Bordero512SendungsElement();
                        $document->addSendung($sendung);
                    }
                    $sendung->addSatzB00($satz);
                } else if (strcmp($satzart, Bordero512SatzG00::SATZART) == 0) {
                    $satz = $this->parseLineSatzG00($satzLine);
                    if (!$satz) {
                        $result->incCountError();
                        $this->logger->err("Borderofile '" . $file->getFilename() . "' kann G00-Satz nicht verarbeiten (Zeile " . $currentLineNumber . ")!", ["classMethod"=>__METHOD__]);
                        return NULL;
                    }
                    $sendung->setSatzG00($satz);
                } else if (strcmp($satzart, Bordero512SatzH10::SATZART) == 0) {
                    $satz = $this->parseLineSatzH10($satzLine);
                    if (!$satz) {
                        $result->incCountError();
                        $this->logger->err("Borderofile '" . $file->getFilename() . "' kann H10-Satz nicht verarbeiten (Zeile " . $currentLineNumber . ")!", ["classMethod"=>__METHOD__]);
                        return NULL;
                    }
                    $sendung->setSatzH10($satz);
                } else if (strcmp($satzart, Bordero512SatzD00::SATZART) == 0) {
                    $satzD00 = $this->parseLineSatzD00($satzLine);
                    if (!$satzD00) {
                        $result->incCountError();
                        $this->logger->err("Borderofile '" . $file->getFilename() . "' kann D00-Satz nicht verarbeiten (Zeile " . $currentLineNumber . ")!", ["classMethod"=>__METHOD__]);
                        return NULL;
                    }
                    $sendung->addSatzD00($satzD00);
                } else if (strcmp($satzart, Bordero512SatzF00::SATZART) == 0) {
                    $satzF00 = $this->parseLineSatzF00($satzLine);
                    if (!$satzF00) {
                        $result->incCountError();
                        $this->logger->err("Borderofile '" . $file->getFilename() . "' kann F00-Satz nicht verarbeiten (Zeile " . $currentLineNumber . ")!", ["classMethod"=>__METHOD__]);
                        return NULL;
                    }
                    $satzD00->addSatzF00($satzF00);
                }
                
                $currentLineNumber++;
            }
        }

        return $document;
    }
    
    private static function parseLineSatzA00(string $line): ?Bordero512SatzA00 {
        $satz = new Bordero512SatzA00();
        $satz->setBorderoNummer(self::parseString(substr($line, 10 - 1, 35)));
        $satz->setBorderoDatum(self::parseDate(substr($line, 45 - 1, 8)));
        $satz->setReleaseKennung(self::parseString(substr($line, 7 - 1, 3)));
        return $satz;
    }
    
    private static function parseLineSatzB00(string $line): ?Bordero512SatzB00 {
        $satz = new Bordero512SatzB00(self::parseInt(substr($line, 4 - 1, 3)));
        $satz->setAdressArt(self::parseString(substr($line, 7 - 1, 3)));
        $satz->setName1(self::parseString(substr($line, 10 - 1, 35)));
        $satz->setStrasse(self::parseString(substr($line, 45 - 1, 35)));
        $satz->setLand(self::parseString(substr($line, 80 - 1, 3)));
        $satz->setPlz(self::parseString(substr($line, 83 - 1, 9)));
        $satz->setOrt(self::parseString(substr($line, 92 - 1, 35)));
        $satz->setName2(self::parseString(substr($line, 162 - 1, 35)));
        return $satz;
    }
    
    private static function parseLineSatzG00(string $line): ?Bordero512SatzG00 {
        $satz = new Bordero512SatzG00(self::parseInt(substr($line, 4 - 1, 3)));
        $satz->setSendungsNummer(self::parseString(substr($line, 7 - 1, 35)));
        $satz->setTatsaechlichesGewicht(self::parseFloat(substr($line, 42 - 1, 9), 3));
        return $satz;
    }

    private static function parseLineSatzH10(string $line): ?Bordero512SatzH10 {
        $satz = new Bordero512SatzH10(self::parseInt(substr($line, 4 - 1, 3)));
        $txt1 = self::parseString(substr($line, 10 - 1, 70));
        $satz->setFreierText1($txt1 ? $txt1 : ""); //possible!
        $satz->setFreierText2(self::parseString(substr($line, 83 - 1, 70)));
        $satz->setFreierText3(self::parseString(substr($line, 156 - 1, 70)));
        return $satz;
    }

    private static function parseLineSatzD00(string $line): ?Bordero512SatzD00 {
        $satz = new Bordero512SatzD00(self::parseInt(substr($line, 4 - 1, 3)));
        $satz->setSendungsPosition(self::parseInt(substr($line, 7 - 1, 3)));
        $satz->setPackstueckAnzahl(self::parseInt(substr($line, 10 - 1, 4)));
        $satz->setVerpackungsArt(self::parseString(substr($line, 14 - 1, 3)));
        $satz->setWarenInhalt(self::parseString(substr($line, 24 - 1, 35)));
        return $satz;
    }
    
    private static function parseLineSatzF00(string $line): ?Bordero512SatzF00 {
        $satz = new Bordero512SatzF00(self::parseInt(substr($line, 4 - 1, 3)));
        $satz->setSendungsPosition(self::parseInt(substr($line, 7 - 1, 3)));
        $satz->setBarcode(self::parseString(substr($line, 10 - 1, 35)));
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
    
    private static function parseFloat(?string $field, int $decimalCount): ?float {
        $parsedField = self::parseString($field);
        if (!$parsedField)
            return NULL;

        $iVal = (int) $parsedField;
        $iDec = 10 ** $decimalCount;
        return $iDec!=0 ? (float)$iVal / (float)$iDec : (float)$iVal;
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
