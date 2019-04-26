<?php

namespace Application\Util\Log;

use Zend\Log\Processor\ProcessorInterface;

class LogProcessor implements ProcessorInterface {

    public function process(array $event) {
        if (isset($event['extra']['requestMethod'])) {
            return $event;
        }

        if (!isset($event['extra'])) {
            $event['extra'] = [];
        }

        $event['extra']['requestMethod'] = $_SERVER['REQUEST_METHOD'];
        $event['extra']['requestURI'] = $_SERVER['REQUEST_URI'];
        $event['extra']['requestParams'] = json_encode($_REQUEST);
        return $event;
    }

    /**
     * Provide unique identifier for a request
     *
     * @return string
     */
    public static function getRequestId(): string {
        $identifier = (string) $_SERVER['REQUEST_TIME_FLOAT'];

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $identifier .= $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $identifier .= $_SERVER['REMOTE_ADDR'];
        }

        return md5($identifier);
    }

}
