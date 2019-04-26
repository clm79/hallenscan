<?php

namespace Application\IO\Bordero;

/**
 * Packstueck-Satz (H)
 *
 * @author cmartin
 */
class Bordero128SatzH extends Bordero128SatzBase {

    public const SATZART = "H";

    /* @var string */

    private $barcode;

    public function __construct(int $position) {
        parent::__construct(self::SATZART, $position);
    }

    public function getBarcode():string {
        return $this->barcode;
    }

    public function setBarcode(string $barcode) {
        $this->barcode = $barcode;
    }

}
