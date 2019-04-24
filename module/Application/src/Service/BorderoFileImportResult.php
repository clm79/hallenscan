<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Service;

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

    public function incCount() {
        $this->count++;
    }

    public function incCountError() {
        $this->countError++;
    }

    public function getCount() {
        return $this->count;
    }

    public function getCountError() {
        return $this->countError;
    }
    
}
