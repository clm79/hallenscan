<?php

namespace Application\IO\Bordero;

/**
 * Description of Bordero128Header
 *
 * @author cmartin
 */
class Bordero128Header {
    /* @var string */

    private $packageId;

    /* @var string */
    private $versandDepotKennung;

    /* @var string */
    private $empfangsDepotKennung;

    public function getPackageId(): string {
        return $this->packageId;
    }

    public function getVersandDepotKennung(): string {
        return $this->versandDepotKennung;
    }

    public function getEmpfangsDepotKennung(): string {
        return $this->empfangsDepotKennung;
    }

    public function setPackageId(string $packageId) {
        $this->packageId = $packageId;
    }
    
    public function setVersandDepotKennung(string $versandDepotKennung) {
        $this->versandDepotKennung = $versandDepotKennung;
    }

    public function setEmpfangsDepotKennung(string $empfangsDepotKennung) {
        $this->empfangsDepotKennung = $empfangsDepotKennung;
    }

}
