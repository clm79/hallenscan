<?php

namespace Application\IO\Bordero;

/**
 * Sendungs-Positions-Satz (F)
 *
 * @author cmartin
 */
class Bordero128SatzF extends Bordero128SatzBase {

    public const SATZART = "F";

    /* @var int */
    private $anzahlLademittel;
    /* @var string */
    private $lademittelArt;
    /* @var string */
    private $wareninhalt;
    /* @var string */
    private $sendungsnummer;

    public function __construct(int $position) {
        parent::__construct(self::SATZART, $position);
    }
    
    public function getAnzahlLademittel():int {
        return $this->anzahlLademittel;
    }

    public function getLademittelArt():string {
        return $this->lademittelArt;
    }

    public function getWareninhalt():?string {
        return $this->wareninhalt;
    }

    public function getSendungsnummer():string {
        return $this->sendungsnummer;
    }

    public function setAnzahlLademittel(int $anzahlLademittel) {
        $this->anzahlLademittel = $anzahlLademittel;
    }

    public function setLademittelArt(string $lademittelArt) {
        $this->lademittelArt = $lademittelArt;
    }

    public function setWareninhalt(?string $wareninhalt) {
        $this->wareninhalt = $wareninhalt;
    }

    public function setSendungsnummer(string $sendungsnummer) {
        $this->sendungsnummer = $sendungsnummer;
    }
}
