<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="bordero")
 */
class Bordero extends AbstractTable {

    /**
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Hub", inversedBy="borderos")
     * @ORM\JoinColumn(name="hub_id", referencedColumnName="interne_id")
     */
    private $hub;

    /**
     * @ORM\Column(name="import_dateiname")
     */
    private $importDateiname;

    /**
     * @ORM\Column(name="nummer")
     */
    private $nummer;

    /**
     * @ORM\Column(name="datum", type="date")
     */
    private $datum;

    /**
     * @ORM\Column(name="empfangs_depot_kennung")
     */
    private $empfangsDepotKennung;

    /**
     * @ORM\Column(name="release_kennung")
     */
    private $releaseKennung;

    /**
     * @ORM\OneToMany(targetEntity="\Application\Entity\Sendung", mappedBy="bordero")
     * @ORM\JoinColumn(name="interne_id", referencedColumnName="sendung_id")
     */
    private $sendungen;

    public function __construct() {
        $this->sendungen = new ArrayCollection();
    }

    public function getHub() {
        return $this->hub;
    }

    public function getImportDateiname() {
        return $this->importDateiname;
    }

    public function getNummer() {
        return $this->nummer;
    }

    public function getDatum() {
        return $this->datum;
    }

    public function getEmpfangsDepotKennung() {
        return $this->empfangsDepotKennung;
    }

    public function getReleaseKennung() {
        return $this->releaseKennung;
    }

    public function getSendungen() {
        return $this->sendungen;
    }

    public function setHub($hub) {
        $this->hub = $hub;
    }

    public function setImportDateiname($importDateiname) {
        $this->importDateiname = $importDateiname;
    }

    public function setNummer($nummer) {
        $this->nummer = $nummer;
    }

    public function setDatum($datum) {
        $this->datum = $datum;
    }

    public function setEmpfangsDepotKennung($empfangsDepotKennung) {
        $this->empfangsDepotKennung = $empfangsDepotKennung;
    }

    public function setReleaseKennung($releaseKennung) {
        $this->releaseKennung = $releaseKennung;
    }

    public function setSendungen($sendungen) {
        $this->sendungen = $sendungen;
    }

}
