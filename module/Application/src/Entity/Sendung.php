<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="sendung") 
 */
class Sendung extends AbstractTable {

    /**
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Bordero", inversedBy="sendungen")
     * @ORM\JoinColumn(name="bordero_id", referencedColumnName="interne_id")
     */
    private $bordero;

    /**
     * @ORM\Column(name="bordero_position")  
     */
    private $borderoPosition;

    /**
     * @ORM\Column(name="versender_name1")  
     */
    private $versenderName1;

    /**
     * @ORM\Column(name="versender_name2")  
     */
    private $versenderName2;

    /**
     * @ORM\Column(name="versender_strasse")  
     */
    private $versenderStrasse;

    /**
     * @ORM\Column(name="versender_plz")  
     */
    private $versenderPlz;

    /**
     * @ORM\Column(name="versender_ort")  
     */
    private $versenderOrt;

    /**
     * @ORM\Column(name="versender_land")  
     */
    private $versenderLand;

    /**
     * @ORM\Column(name="empfaenger_name1")  
     */
    private $empfaengerName1;

    /**
     * @ORM\Column(name="empfaenger_name2")  
     */
    private $empfaengerName2;

    /**
     * @ORM\Column(name="empfaenger_strasse")  
     */
    private $empfaengerStrasse;

    /**
     * @ORM\Column(name="empfaenger_plz")  
     */
    private $empfaengerPlz;

    /**
     * @ORM\Column(name="empfaenger_ort")  
     */
    private $empfaengerOrt;

    /**
     * @ORM\Column(name="empfaenger_land")  
     */
    private $empfaengerLand;

    /**
     * @ORM\Column(name="sendungsnummer")  
     */
    private $sendungsnummer;

    /**
     * @ORM\Column(name="gewicht")  
     */
    private $gewicht;

    /**
     * @ORM\Column(name="hinweis_text")  
     */
    private $hinweisText;

    /**
     * @ORM\OneToMany(targetEntity="\Application\Entity\Colli", mappedBy="sendung")
     * @ORM\JoinColumn(name="interne_id", referencedColumnName="colli_id")
     */
    private $collis;

    public function __construct() {
        $this->collis = new ArrayCollection();
    }

    public function getBordero() {
        return $this->bordero;
    }

    public function getBorderoPosition() {
        return $this->borderoPosition;
    }

    public function getVersenderName1() {
        return $this->versenderName1;
    }

    public function getVersenderName2() {
        return $this->versenderName2;
    }

    public function getVersenderStrasse() {
        return $this->versenderStrasse;
    }

    public function getVersenderPlz() {
        return $this->versenderPlz;
    }

    public function getVersenderOrt() {
        return $this->versenderOrt;
    }

    public function getVersenderLand() {
        return $this->versenderLand;
    }

    public function getEmpfaengerName1() {
        return $this->empfaengerName1;
    }

    public function getEmpfaengerName2() {
        return $this->empfaengerName2;
    }

    public function getEmpfaengerStrasse() {
        return $this->empfaengerStrasse;
    }

    public function getEmpfaengerPlz() {
        return $this->empfaengerPlz;
    }

    public function getEmpfaengerOrt() {
        return $this->empfaengerOrt;
    }

    public function getEmpfaengerLand() {
        return $this->empfaengerLand;
    }

    public function getSendungsnummer() {
        return $this->sendungsnummer;
    }

    public function getCollis() {
        return $this->collis;
    }

    public function setBordero($bordero) {
        $this->bordero = $bordero;
    }

    public function setBorderoPosition($borderoPosition) {
        $this->borderoPosition = $borderoPosition;
    }

    public function setVersenderName1($versenderName1) {
        $this->versenderName1 = $versenderName1;
    }

    public function setVersenderName2($versenderName2) {
        $this->versenderName2 = $versenderName2;
    }

    public function setVersenderStrasse($versenderStrasse) {
        $this->versenderStrasse = $versenderStrasse;
    }

    public function setVersenderPlz($versenderPlz) {
        $this->versenderPlz = $versenderPlz;
    }

    public function setVersenderOrt($versenderOrt) {
        $this->versenderOrt = $versenderOrt;
    }

    public function setVersenderLand($versenderLand) {
        $this->versenderLand = $versenderLand;
    }

    public function setEmpfaengerName1($empfaengerName1) {
        $this->empfaengerName1 = $empfaengerName1;
    }

    public function setEmpfaengerName2($empfaengerName2) {
        $this->empfaengerName2 = $empfaengerName2;
    }

    public function setEmpfaengerStrasse($empfaengerStrasse) {
        $this->empfaengerStrasse = $empfaengerStrasse;
    }

    public function setEmpfaengerPlz($empfaengerPlz) {
        $this->empfaengerPlz = $empfaengerPlz;
    }

    public function setEmpfaengerOrt($empfaengerOrt) {
        $this->empfaengerOrt = $empfaengerOrt;
    }

    public function setEmpfaengerLand($empfaengerLand) {
        $this->empfaengerLand = $empfaengerLand;
    }

    public function setSendungsnummer($sendungsnummer) {
        $this->sendungsnummer = $sendungsnummer;
    }

    public function setCollis($collis) {
        $this->collis = $collis;
    }

    public function getGewicht() {
        return $this->gewicht;
    }

    public function setGewicht($gewicht) {
        $this->gewicht = $gewicht;
    }

    public function getHinweisText() {
        return $this->hinweisText;
    }

    public function setHinweisText($hinweisText) {
        $this->hinweisText = $hinweisText;
    }

}
