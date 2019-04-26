<?php

namespace Application\IO\Bordero;

/**
 * Empfaenger-Adress-Satz Teil 1 (D)
 *
 * @author cmartin
 */
class Bordero128SatzD extends Bordero128SatzBase {

    public const SATZART = "D";

    /* @var string */

    private $empfaengerName1;
    /* @var string */
    private $empfaengerName2;

    public function __construct(int $position) {
        parent::__construct(self::SATZART, $position);
    }
    public function getEmpfaengerName1():string {
        return $this->empfaengerName1;
    }

    public function getEmpfaengerName2():?string {
        return $this->empfaengerName2;
    }

    public function setEmpfaengerName1(string $empfaengerName1) {
        $this->empfaengerName1 = $empfaengerName1;
    }

    public function setEmpfaengerName2(?string $empfaengerName2) {
        $this->empfaengerName2 = $empfaengerName2;
    }


}
