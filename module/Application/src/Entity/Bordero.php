<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bordero") 
 */
class Bordero extends AbstractTable {

    /**
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Hub", inversedBy="borderos")
     * @ORM\JoinColumn(name="hub_id", referencedColumnName="interne_id")
     */
    protected $hub;

    /**
     * @ORM\Column(name="nummer")  
     */
    protected $nummer;

    /**
     * @ORM\OneToMany(targetEntity="\Application\Entity\Sendung", mappedBy="sendung")
     * @ORM\JoinColumn(name="interne_id", referencedColumnName="sendung_id")
     */
    protected $sendungen;

    public function __construct() {
        $this->sendungen = new ArrayCollection();
    }
    public function getHub() {
        return $this->hub;
    }

    public function getNummer() {
        return $this->nummer;
    }

    public function getSendungen() {
        return $this->sendungen;
    }

    public function setHub($hub) {
        $this->hub = $hub;
    }

    public function setNummer($nummer) {
        $this->nummer = $nummer;
    }

    public function setSendungen($sendungen) {
        $this->sendungen = $sendungen;
    }


}
