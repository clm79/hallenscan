<?php

namespace Application\IO\Bordero;

/**
 * Description of Bordero512Document
 *
 * @author cmartin
 */
class Bordero512Document {
    /* @var Bordero512Header */

    private $header;
    
    /* @var Bordero512SatzA00 */
    private $satzA00;
    
    /* @var Bordero512SendungsElement[] */
    private $sendungen = array();
    

    public function getHeader() : Bordero512Header {
        return $this->header;
    }

    public function setHeader(Bordero512Header $header) {
        $this->header = $header;
    }
    public function getSatzA00() : Bordero512SatzA00 {
        return $this->satzA00;
    }

    public function setSatzA00(Bordero512SatzA00 $satzA00) {
        $this->satzA00 = $satzA00;
    }
    
    public function getSendungen() {
        return $this->sendungen;
    }

    public function addSendung(Bordero512SendungsElement $sendung) {
        $this->sendungen[] = $sendung;
    }
}
