<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="nv_relation") 
 */
class NvRelation extends AbstractStammdatenTable {

    /**
     * @ORM\Column(name="land")  
     */
    private $land;

    /**
     * @ORM\Column(name="plz")  
     */
    private $plz;

    /**
     * @ORM\Column(name="relation")  
     */
    private $relation;

    public function getLand() {
        return $this->land;
    }

    public function getPlz() {
        return $this->plz;
    }

    public function getRelation() {
        return $this->relation;
    }

    public function setLand($land) {
        $this->land = $land;
    }

    public function setPlz($plz) {
        $this->plz = $plz;
    }

    public function setRelation($relation) {
        $this->relation = $relation;
    }

}
