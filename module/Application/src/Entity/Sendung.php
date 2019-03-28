<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sendung") 
 */
class Sendung extends AbstractTable {

    /**
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Bordero", inversedBy="sendungen")
     * @ORM\JoinColumn(name="bordero_id", referencedColumnName="interne_id")
     */
    protected $bordero;

    /**
     * @ORM\Column(name="barcode")  
     */
    protected $barcode;

    /**
     * @ORM\OneToMany(targetEntity="\Application\Entity\Colli", mappedBy="colli")
     * @ORM\JoinColumn(name="interne_id", referencedColumnName="colli_id")
     */
    protected $collis;

    public function __construct() {
        $this->collis = new ArrayCollection();
    }
    public function getBordero() {
        return $this->bordero;
    }

    public function getBarcode() {
        return $this->barcode;
    }

    public function getCollis() {
        return $this->collis;
    }

    public function setBordero($bordero) {
        $this->bordero = $bordero;
    }

    public function setBarcode($barcode) {
        $this->barcode = $barcode;
    }

    public function setCollis($collis) {
        $this->collis = $collis;
    }


}
