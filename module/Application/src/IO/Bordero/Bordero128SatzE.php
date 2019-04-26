<?php

namespace Application\IO\Bordero;

/**
 * Empfaenger-Adress-Satz Teil 2 (E)
 *
 * @author cmartin
 */
class Bordero128SatzE extends Bordero128SatzBase {

    public const SATZART = "E";

    /* @var string */

    private $empfaengerStrasse;
    /* @var string */
    private $empfaengerLand;
    /* @var string */
    private $empfaengerPLZ;
    /* @var string */
    private $empfaengerOrt;

    public function __construct(int $position) {
        parent::__construct(self::SATZART, $position);
    }

    public function getEmpfaengerStrasse():string {
        return $this->empfaengerStrasse;
    }

    public function getEmpfaengerLand():string {
        return $this->empfaengerLand;
    }

    public function getEmpfaengerPLZ():string {
        return $this->empfaengerPLZ;
    }

    public function getEmpfaengerOrt():string {
        return $this->empfaengerOrt;
    }

    public function setEmpfaengerStrasse(string $empfaengerStrasse) {
        $this->empfaengerStrasse = $empfaengerStrasse;
    }

    public function setEmpfaengerLand(string $empfaengerLand) {
        $this->empfaengerLand = $empfaengerLand;
    }

    public function setEmpfaengerPLZ(string $empfaengerPLZ) {
        $this->empfaengerPLZ = $empfaengerPLZ;
    }

    public function setEmpfaengerOrt(string $empfaengerOrt) {
        $this->empfaengerOrt = $empfaengerOrt;
    }

}
