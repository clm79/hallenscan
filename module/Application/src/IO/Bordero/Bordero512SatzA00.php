<?php

namespace Application\IO\Bordero;

use DateTime;

/**
 * Bordero-Kopf-Satz (A00)
 *
 * @author cmartin
 */
class Bordero512SatzA00 extends Bordero512SatzBase {

    public const SATZART = "A00";

    /* @var string */
    private $releaseKennung;
    
    /* @var string */
    private $borderoNummer;

    /* @var DateTime */
    private $borderoDatum;

    public function __construct() {
        parent::__construct(self::SATZART, 0);
    }

    public function getBorderoNummer(): string {
        return $this->borderoNummer;
    }

    public function getBorderoDatum(): DateTime {
        return $this->borderoDatum;
    }

    public function getReleaseKennung(): string {
        return $this->releaseKennung;
    }

    public function setBorderoNummer(string $borderoNummer) {
        $this->borderoNummer = $borderoNummer;
    }

    public function setBorderoDatum(DateTime $borderoDatum) {
        $this->borderoDatum = $borderoDatum;
    }

    public function setReleaseKennung(string $releaseKennung) {
        $this->releaseKennung = $releaseKennung;
    }

}
