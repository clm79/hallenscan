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
    private $name;

    /**
     * @ORM\Column(name="eigene_depot_kennung")  
     */
    private $eigeneDepotKennung;

    /**
     * @ORM\Column(name="bordero_import_pfad")  
     */
    private $borderoImportPfad;

    /**
     * @ORM\Column(name="bordero_import_pattern")  
     */
    private $borderoImportPattern;
    
    /**
     * @ORM\OneToMany(targetEntity="\Application\Entity\Hub", mappedBy="partner")
     * @ORM\JoinColumn(name="interne_id", referencedColumnName="hub_id")
     */
    private $hubs;

    /**
     * Constructor.
     */
    public function __construct() {
        $this->$hubs = new ArrayCollection();
    }

    public function getName() {
        return $this->name;
    }

    public function getEigeneDepotKennung() {
        return $this->eigeneDepotKennung;
    }

    public function getBorderoImportPfad() {
        return $this->borderoImportPfad;
    }

    public function getBorderoImportPattern() {
        return $this->borderoImportPattern;
    }

    public function getHubs() {
        return $this->hubs;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setEigeneDepotKennung($eigeneDepotKennung) {
        $this->eigeneDepotKennung = $eigeneDepotKennung;
    }

    public function setBorderoImportPfad($borderoImportPfad) {
        $this->borderoImportPfad = $borderoImportPfad;
    }

    public function setBorderoImportPattern($borderoImportPattern) {
        $this->borderoImportPattern = $borderoImportPattern;
    }

    public function setHubs($hubs) {
        $this->hubs = $hubs;
    }


}
