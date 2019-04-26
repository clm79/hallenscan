<?php

namespace Application\IO\Bordero;

/**
 * Versender-Adress-Satz Teil 2 (C)
 *
 * @author cmartin
 */
class Bordero128SatzC extends Bordero128SatzBase {

    public const SATZART = "C";

    /* @var string */

    private $versenderOrt;

    public function __construct(int $position) {
        parent::__construct(self::SATZART, $position);
    }

    public function getVersenderOrt():string {
        return $this->versenderOrt;
    }

    public function setVersenderOrt(string $versenderOrt) {
        $this->versenderOrt = $versenderOrt;
    }

}
