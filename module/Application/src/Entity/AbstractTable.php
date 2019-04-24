<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

abstract class AbstractTable {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="interne_id")   
     */
    protected $interneId;

    /**
     * @ORM\Column(name="zeitstempel", type="datetime")  
     */
    protected $zeitstempel;

    public function getInterneId() {
        return $this->interneId;
    }

    public function getZeitstempel() {
        return $this->zeitstempel;
    }

    public function setInterneId($interneId) {
        $this->interneId = $interneId;
    }

    public function setZeitstempel($zeitstempel) {
        $this->zeitstempel = $zeitstempel;
    }

}
