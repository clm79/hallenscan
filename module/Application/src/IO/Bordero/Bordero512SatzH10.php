<?php

namespace Application\IO\Bordero;

/**
 * Freie Texte-Satz (H10)
 *
 * @author cmartin
 */
class Bordero512SatzH10 extends Bordero512SatzBase {

    public const SATZART = "H10";

    /* @var string */
    private $freierText1;
    /* @var string */
    private $freierText2;
    /* @var string */
    private $freierText3;

    public function __construct(int $position) {
        parent::__construct(self::SATZART, $position);
    }
    public function getFreierText1():string {
        return $this->freierText1;
    }

    public function setFreierText1(string $freierText1) {
        $this->freierText1 = $freierText1;
    }
    public function getFreierText2() : ?string {
        return $this->freierText2;
    }

    public function getFreierText3() : ?string {
        return $this->freierText3;
    }

    public function setFreierText2(?string $freierText2) {
        $this->freierText2 = $freierText2;
    }

    public function setFreierText3(?string $freierText3) {
        $this->freierText3 = $freierText3;
    }


}
