<?php

namespace Application\IO\Bordero;

/**
 * Versender-Adress-Satz Teil 1 (B)
 *
 * @author cmartin
 */
class Bordero128SatzB extends Bordero128SatzBase {

    public const SATZART = "B";

    /* @var string */

    private $versenderName1;
    /* @var string */
    private $versenderName2;
    /* @var string */
    private $versenderStrasse;
    /* @var string */
    private $versenderLand;
    /* @var string */
    private $versenderPLZ;

    public function __construct(int $position) {
        parent::__construct(self::SATZART, $position);
    }

    public function getVersenderName1():string {
        return $this->versenderName1;
    }

    public function getVersenderName2():?string {
        return $this->versenderName2;
    }

    public function getVersenderStrasse():string {
        return $this->versenderStrasse;
    }

    public function getVersenderLand():string {
        return $this->versenderLand;
    }

    public function getVersenderPLZ():string {
        return $this->versenderPLZ;
    }

    public function setVersenderName1(string $versenderName1) {
        $this->versenderName1 = $versenderName1;
    }

    public function setVersenderName2(?string $versenderName2) {
        $this->versenderName2 = $versenderName2;
    }

    public function setVersenderStrasse(string $versenderStrasse) {
        $this->versenderStrasse = $versenderStrasse;
    }

    public function setVersenderLand(string $versenderLand) {
        $this->versenderLand = $versenderLand;
    }

    public function setVersenderPLZ(string $versenderPLZ) {
        $this->versenderPLZ = $versenderPLZ;
    }

}
