<?php

namespace Application\IO\Bordero;

/**
 * Adress-Satz (B00)
 *
 * @author cmartin
 */
class Bordero512SatzB00 extends Bordero512SatzBase {

    public const SATZART = "B00";

    /* @var string */

    private $adressArt;

    /* @var string */
    private $name1;

    /* @var string */
    private $strasse;

    /* @var string */
    private $land;

    /* @var string */
    private $plz;

    /* @var string */
    private $ort;

    /* @var string */
    private $name2;
    
    public function __construct(int $position) {
        parent::__construct(self::SATZART, $position);
    }
    

    public function getAdressArt():string {
        return $this->adressArt;
    }

    public function getName1():string {
        return $this->name1;
    }

    public function getStrasse():string {
        return $this->strasse;
    }

    public function getLand():string {
        return $this->land;
    }

    public function getPlz():string {
        return $this->plz;
    }

    public function getOrt():string {
        return $this->ort;
    }

    public function getName2():?string {
        return $this->name2;
    }

    public function setAdressArt(string $adressArt) {
        $this->adressArt = $adressArt;
    }

    public function setName1(string $name1) {
        $this->name1 = $name1;
    }

    public function setStrasse(string $strasse) {
        $this->strasse = $strasse;
    }

    public function setLand(string $land) {
        $this->land = $land;
    }

    public function setPlz(string $plz) {
        $this->plz = $plz;
    }

    public function setOrt(string $ort) {
        $this->ort = $ort;
    }

    public function setName2(?string $name2) {
        $this->name2 = $name2;
    }

}
