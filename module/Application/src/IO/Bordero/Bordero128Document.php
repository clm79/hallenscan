<?php

namespace Application\IO\Bordero;

/**
 * Description of Bordero128Document
 *
 * @author cmartin
 */
class Bordero128Document {
    /* @var Bordero128Header */

    private $header;

    /* @var Bordero128SatzA */
    private $satzA;
    
    /* @var Bordero128SendungsElement[] */
    private $sendungen = array();
    
    
    public function getHeader(): Bordero128Header {
        return $this->header;
    }

    public function setHeader(Bordero128Header $header) {
        $this->header = $header;
    }

    public function getSatzA(): Bordero128SatzA {
        return $this->satzA;
    }

    public function setSatzA(Bordero128SatzA $satzA) {
        $this->satzA = $satzA;
    }
    
    public function addSendung(Bordero128SendungsElement $sendung) {
        $this->sendungen[] = $sendung;
    }
    
    public function getSendungen() {
        return $this->sendungen;
    }
}
