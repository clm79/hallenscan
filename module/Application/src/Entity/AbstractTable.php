<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

abstract class AbstractTable {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="interne_id")   
     */
    protected $InterneId;

    /**
     * @ORM\Column(name="zeitstempel")  
     */
    protected $zeitstempel;

    public function getInterneId() {
        return $this->InterneId;
    }

    public function getZeitstempel() {
        return $this->zeitstempel;
    }

    public function setInterneId($InterneId) {
        $this->InterneId = $InterneId;
    }

    public function setZeitstempel($zeitstempel) {
        $this->zeitstempel = $zeitstempel;
    }

}
