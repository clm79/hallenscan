<?php

namespace Application\IO\Bordero;

/**
 * Description of Bordero512SatzBase
 *
 * @author cmartin
 */
abstract class Bordero512SatzBase {
    /* @var string */

    private $satzart;

    /* @var int */
    private $position;

    public function __construct(string $satzart, int $position) {
        $this->satzart = $satzart;
        $this->position = $position;
    }

    public function getSatzart(): string {
        return $this->satzart;
    }

    public function getPosition(): int {
        return $this->position;
    }

    public function setSatzart(string $satzart) {
        $this->satzart = $satzart;
    }

    public function setPosition(int $position) {
        $this->position = $position;
    }

}
