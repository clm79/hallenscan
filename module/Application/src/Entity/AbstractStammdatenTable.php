<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

abstract class AbstractStammdatenTable extends AbstractTable {

    /**
     * @ORM\Column(name="aktiv")  
     */
    protected $aktiv;

    public function getAktiv() {
        return $this->aktiv;
    }

    public function setAktiv($aktiv) {
        $this->aktiv = $aktiv;
    }

}
