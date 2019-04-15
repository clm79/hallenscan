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
    
    public function inc() {
        $this->count++;
    }
    
    public function getCount() {
        return $this->count;
    }
}
