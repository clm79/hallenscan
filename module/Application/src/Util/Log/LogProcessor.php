<?php

namespace Application\Util\Log;

use Zend\Log\Processor\ProcessorInterface;

class LogProcessor implements ProcessorInterface {

    public function process(array $event) {
        if (isset($event['extra']['requestMethod'])) {
            return $event;
        }

        if (! isset($event['extra'])) {
            $event['extra'] = [];
        }

        $event['extra']['requestMethod'] = $_SERVER['REQUEST_METHOD'];
        $event['extra']['requestURI'] = $_SERVER['REQUEST_URI'];
        $event['extra']['requestParams'] = json_encode($_REQUEST);
        return $event;        
    }

}
