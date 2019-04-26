<?php

namespace Application\IO\Bordero;

use DateTime;

/**
 * Bordero-Kopf-Satz (A)
 *
 * @author cmartin
 */
class Bordero128SatzA extends Bordero128SatzBase {

    public const SATZART = "A";

    /* @var string */

    private $borderoNummer;

    /* @var DateTime */
    private $versandDatum;

    /* @var string */
    private $releaseKennung;

    public function __construct() {
        parent::__construct(self::SATZART, 0);
    }

    public function getBorderoNummer(): string {
        return $this->borderoNummer;
    }

    public function getVersandDatum(): DateTime {
        return $this->versandDatum;
    }

    public function getReleaseKennung(): string {
        return $this->releaseKennung;
    }

    public function setBorderoNummer(string $borderoNummer) {
        $this->borderoNummer = $borderoNummer;
    }

    public function setVersandDatum(DateTime $versandDatum) {
        $this->versandDatum = $versandDatum;
    }

    public function setReleaseKennung(string $releaseKennung) {
        $this->releaseKennung = $releaseKennung;
    }

}
