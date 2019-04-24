<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="hub") 
 */
class Hub extends AbstractStammdatenTable {

    /**
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Partner", inversedBy="hubs")
     * @ORM\JoinColumn(name="partner_id", referencedColumnName="interne_id")
     */
    private $partner;

    /**
     * @ORM\Column(name="name")  
     */
    private $name;

    /**
     * @ORM\Column(name="kennung")  
     */
    private $kennung;

    /**
     * @ORM\OneToMany(targetEntity="\Application\Entity\Bordero", mappedBy="hub")
     * @ORM\JoinColumn(name="interne_id", referencedColumnName="bordero_id")
     */
    private $borderos;

    /**
     * Constructor.
     */
    public function __construct() {
        $this->$borderos = new ArrayCollection();
    }

    public function getPartner() {
        return $this->partner;
    }

    public function getName() {
        return $this->name;
    }

    public function setPartner($partner) {
        $this->partner = $partner;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getKennung() {
        return $this->kennung;
    }

    public function setKennung($kennung) {
        $this->kennung = $kennung;
    }

    public function getBorderos() {
        return $this->borderos;
    }

    public function setBorderos($borderos) {
        $this->borderos = $borderos;
    }

}
