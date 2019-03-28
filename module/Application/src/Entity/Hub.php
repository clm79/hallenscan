<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="hub") 
 */
class Hub extends AbstractStammdatenTable {

    /**
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Partner", inversedBy="hubs")
     * @ORM\JoinColumn(name="partner_id", referencedColumnName="interne_id")
     */
    protected $partner;

    /**
     * @ORM\Column(name="name")  
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="\Application\Entity\Bordero", mappedBy="bordero")
     * @ORM\JoinColumn(name="interne_id", referencedColumnName="bordero_id")
     */
    protected $borderos;

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

    public function getBorderos() {
        return $this->borderos;
    }

    public function setBorderos($borderos) {
        $this->borderos = $borderos;
    }

}
