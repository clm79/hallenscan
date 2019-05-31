<?php

namespace Application\IO\Bordero;

/**
 * Sendungsposition-Satz (D00)
 *
 * @author cmartin
 */
class Bordero512SatzD00 extends Bordero512SatzBase {

    public const SATZART = "D00";

    /* @var int */

    private $sendungsPosition;

    /* @var int */
    private $packstueckAnzahl;

    /* @var string */
    private $verpackungsArt;

    /* @var string */
    private $warenInhalt;

    /* @var Bordero512SatzF00[] */
    private $satzF00s = array();

    public function __construct(int $position) {
        parent::__construct(self::SATZART, $position);
    }

    public function getSendungsPosition(): int {
        return $this->sendungsPosition;
    }

    public function getPackstueckAnzahl(): int {
        return $this->packstueckAnzahl;
    }

    public function getVerpackungsArt(): string {
        return $this->verpackungsArt;
    }

    public function getWarenInhalt(): string {
        return $this->warenInhalt;
    }

    public function getSatzF00s() {
        return $this->satzF00s;
    }

    public function setSendungsPosition(int $sendungsPosition) {
        $this->sendungsPosition = $sendungsPosition;
    }

    public function setPackstueckAnzahl(int $packstueckAnzahl) {
        $this->packstueckAnzahl = $packstueckAnzahl;
    }

    public function setVerpackungsArt(string $verpackungsArt) {
        $this->verpackungsArt = $verpackungsArt;
    }

    public function setWarenInhalt(string $warenInhalt) {
        $this->warenInhalt = $warenInhalt;
    }

    public function addSatzF00(Bordero512SatzF00 $satzF00) {
        $this->satzF00s[] = $satzF00;
    }

}
