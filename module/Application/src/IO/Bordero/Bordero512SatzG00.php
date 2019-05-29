<?php

namespace Application\IO\Bordero;

/**
 * Sendungssummen-Satz (G00)
 *
 * @author cmartin
 */
class Bordero512SatzG00 extends Bordero512SatzBase {

    public const SATZART = "G00";

    /* @var string */

    private $sendungsNummer;

    /* @var float */
    private $tatsaechlichesGewicht;

    public function __construct(int $position) {
        parent::__construct(self::SATZART, $position);
    }

    public function getSendungsNummer(): string {
        return $this->sendungsNummer;
    }

    public function getTatsaechlichesGewicht(): float {
        return $this->tatsaechlichesGewicht;
    }

    public function setSendungsNummer(string $sendungsNummer) {
        $this->sendungsNummer = $sendungsNummer;
    }

    public function setTatsaechlichesGewicht(float $tatsaechlichesGewicht) {
        $this->tatsaechlichesGewicht = $tatsaechlichesGewicht;
    }

}
