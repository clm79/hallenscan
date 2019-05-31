<?php

namespace Application\IO\Bordero;

/**
 * Description of Bordero512SendungsElement
 *
 * @author cmartin
 */
class Bordero512SendungsElement {
    /* @var Bordero512SatzB00[] */

    private $satzB00s = array();

    /* @var Bordero512SatzG00 */
    private $satzG00;

    /* @var Bordero512SatzH10 */
    private $satzH10;

    /* @var Bordero512SatzD00[] */
    private $satzD00s = array();

    public function getSatzB00s() {
        return $this->satzB00s;
    }

    public function getSatzB00ByAdressArt(string $adressArt): ?Bordero512SatzB00 {
        /* @var $satzB00 Bordero512SatzB00 */
        foreach ($this->satzB00s as $satzB00) {
            if (strcmp($adressArt, $satzB00->getAdressArt()) == 0) {
                return $satzB00;
            }
        }
        return NULL;
    }

    public function addSatzB00(Bordero512SatzB00 $satzB00) {
        $this->satzB00s[] = $satzB00;
    }

    public function getSatzG00(): Bordero512SatzG00 {
        return $this->satzG00;
    }

    public function getSatzH10(): ?Bordero512SatzH10 {
        return $this->satzH10;
    }

    public function setSatzG00(Bordero512SatzG00 $satzG00) {
        $this->satzG00 = $satzG00;
    }

    public function setSatzH10(?Bordero512SatzH10 $satzH10) {
        $this->satzH10 = $satzH10;
    }

    public function getSatzD00s() {
        return $this->satzD00s;
    }

    public function addSatzD00(Bordero512SatzD00 $satzD00) {
        $this->satzD00s[] = $satzD00;
    }

}
