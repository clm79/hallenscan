<?php

namespace Application\IO\Bordero;

/**
 * Sendungs-Gewichte, Masse und Hinweise (I)
 *
 * @author cmartin
 */
class Bordero128SatzI extends Bordero128SatzBase {

    public const SATZART = "I";

    /* @var int */

    private $tatsaechlichesGewicht;

    public function __construct(int $position) {
        parent::__construct(self::SATZART, $position);
    }

    public function getTatsaechlichesGewicht(): ?int {
        return $this->tatsaechlichesGewicht;
    }

    public function setTatsaechlichesGewicht(?int $tatsaechlichesGewicht) {
        $this->tatsaechlichesGewicht = $tatsaechlichesGewicht;
    }

}
