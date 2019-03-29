<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="colli") 
 */
class Colli extends AbstractTable {

    /**
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Sendung")
     * @ORM\JoinColumn(name="sendung_id", referencedColumnName="interne_id")
     */
    private $sendung;

    /**
     * @ORM\Column(name="barcode")  
     */
    private $barcode;

    /**
     * @ORM\Column(name="anzahl_lademittel")  
     */
    private $anzahlLademittel;

    /**
     * @ORM\Column(name="lademittelart")  
     */
    private $lademittelart;

    /**
     * @ORM\Column(name="wareninhalt")  
     */
    private $wareninhalt;

    public function getSendung() {
        return $this->sendung;
    }

    public function getBarcode() {
        return $this->barcode;
    }

    public function getAnzahlLademittel() {
        return $this->anzahlLademittel;
    }

    public function getLademittelart() {
        return $this->lademittelart;
    }

    public function getWareninhalt() {
        return $this->wareninhalt;
    }

    public function setSendung($sendung) {
        $this->sendung = $sendung;
    }

    public function setBarcode($barcode) {
        $this->barcode = $barcode;
    }

    public function setAnzahlLademittel($anzahlLademittel) {
        $this->anzahlLademittel = $anzahlLademittel;
    }

    public function setLademittelart($lademittelart) {
        $this->lademittelart = $lademittelart;
    }

    public function setWareninhalt($wareninhalt) {
        $this->wareninhalt = $wareninhalt;
    }

}
