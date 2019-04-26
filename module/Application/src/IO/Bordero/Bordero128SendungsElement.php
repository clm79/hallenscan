<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\IO\Bordero;

/**
 * Description of Bordero128SendungsElement
 *
 * @author cmartin
 */
class Bordero128SendungsElement {
    /* @var Bordero128SatzB */

    private $satzB;

    /* @var Bordero128SatzC */
    private $satzC;

    /* @var Bordero128SatzD */
    private $satzD;

    /* @var Bordero128SatzE */
    private $satzE;

    /* @var Bordero128SatzF[] */
    private $satzFs = array();

    /* @var Bordero128SatzH[] */
    private $satzHs = array();

    /* @var Bordero128SatzI */
    private $satzI;

    /* @var Bordero128SatzJ */
    private $satzJ;

    public function getSatzB(): Bordero128SatzB {
        return $this->satzB;
    }

    public function getSatzC(): Bordero128SatzC {
        return $this->satzC;
    }

    public function getSatzD(): Bordero128SatzD {
        return $this->satzD;
    }

    public function getSatzE(): Bordero128SatzE {
        return $this->satzE;
    }

    public function setSatzB(Bordero128SatzB $satzB) {
        $this->satzB = $satzB;
    }

    public function setSatzC(Bordero128SatzC $satzC) {
        $this->satzC = $satzC;
    }

    public function setSatzD(Bordero128SatzD $satzD) {
        $this->satzD = $satzD;
    }

    public function setSatzE(Bordero128SatzE $satzE) {
        $this->satzE = $satzE;
    }

    public function addSatzF(Bordero128SatzF $satzF) {
        $this->satzFs[] = $satzF;
    }

    public function getSatzFs() {
        return $this->satzFs;
    }

    public function addSatzH(Bordero128SatzH $satzH) {
        $this->satzHs[] = $satzH;
    }

    public function getSatzHs() {
        return $this->satzHs;
    }

    public function getSatzI(): ?Bordero128SatzI {
        return $this->satzI;
    }

    public function getSatzJ(): Bordero128SatzJ {
        return $this->satzJ;
    }

    public function setSatzI(?Bordero128SatzI $satzI) {
        $this->satzI = $satzI;
    }

    public function setSatzJ(?Bordero128SatzJ $satzJ) {
        $this->satzJ = $satzJ;
    }

}
