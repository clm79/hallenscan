<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\IO\Bordero;

/**
 * Description of BorderoFileImportResult
 *
 * @author cmartin
 */
class BorderoFileImportResult {
    /* @var $count int */

    private $count = 0;
    /* @var $countError int */
    private $countError = 0;
    /* @var $countWarning int */
    private $countWarning = 0;

    public function incCount() {
        $this->count++;
    }

    public function incCountError() {
        $this->countError++;
    }

    public function incCountWarning() {
        $this->countWarning++;
    }

    public function getCount() {
        return $this->count;
    }

    public function getCountError() {
        return $this->countError;
    }

    public function getCountWarning() {
        return $this->countWarning;
    }

}
