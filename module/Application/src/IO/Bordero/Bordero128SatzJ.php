<?php

namespace Application\IO\Bordero;

/**
 * Hinweise (J)
 *
 * @author cmartin
 */
class Bordero128SatzJ extends Bordero128SatzBase {

    public const SATZART = "J";

    /* @var string */

    private $infoFeld;

    public function __construct(int $position) {
        parent::__construct(self::SATZART, $position);
    }

    public function getInfoFeld(): ?string {
        return $this->infoFeld;
    }

    public function setInfoFeld(?string $infoFeld) {
        $this->infoFeld = $infoFeld;
    }

}
