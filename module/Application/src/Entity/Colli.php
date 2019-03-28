<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="colli") 
 */
class Colli extends AbstractTable {

    /**
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Sendung")
     * @ORM\JoinColumn(name="sendung_id", referencedColumnName="interne_id")
     */
    protected $sendung;

    /**
     * @ORM\Column(name="barcode")  
     */
    protected $barcode;

    public function getSendung() {
        return $this->sendung;
    }

    public function getBarcode() {
        return $this->barcode;
    }

    public function setSendung($sendung) {
        $this->sendung = $sendung;
    }

    public function setBarcode($barcode) {
        $this->barcode = $barcode;
    }


}
