<?php

namespace Application\IO\Bordero;

/**
 * Barcode-Satz (F00)
 *
 * @author cmartin
 */
class Bordero512SatzF00 extends Bordero512SatzBase {

    public const SATZART = "F00";

    /* @var int */

    private $sendungsPosition;

    /* @var string */
    private $barcode;

    public function __construct(int $position) {
        parent::__construct(self::SATZART, $position);
    }

    public function getSendungsPosition():int {
        return $this->sendungsPosition;
    }

    public function getBarcode():string {
        return $this->barcode;
    }

    public function setSendungsPosition(int $sendungsPosition) {
        $this->sendungsPosition = $sendungsPosition;
    }

    public function setBarcode(string $barcode) {
        $this->barcode = $barcode;
    }

}
