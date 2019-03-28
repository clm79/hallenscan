<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="partner") 
 */
class Partner extends AbstractStammdatenTable {

    /**
     * @ORM\Column(name="name")  
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="\Application\Entity\Hub", mappedBy="hub")
     * @ORM\JoinColumn(name="interne_id", referencedColumnName="hub_id")
     */
    protected $hubs;

    /**
     * Constructor.
     */
    public function __construct() {
        $this->$hubs = new ArrayCollection();
    }

    public function getName() {
        return $this->name;
    }

    public function getHubs() {
        return $this->hubs;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setHubs($hubs) {
        $this->hubs = $hubs;
    }

}
