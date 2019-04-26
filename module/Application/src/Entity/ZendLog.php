<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="zend_log") 
 */
class ZendLog {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="interne_id")   
     */
    private $interneId;

    /**
     * @ORM\Column(name="timestamp", type="datetime")  
     */
    private $timestamp;

    /**
     * @ORM\Column(name="priority")  
     */
    private $priority;

    /**
     * @ORM\Column(name="priorityName")  
     */
    private $priorityName;

    /**
     * @ORM\Column(name="message")  
     */
    private $message;

    /**
     * @ORM\Column(name="extra_classMethod")  
     */
    private $extraClassMethod;
    
    /**
     * @ORM\Column(name="extra_requestId")  
     */
    private $extraRequestId;

    /**
     * @ORM\Column(name="extra_requestMethod")  
     */
    private $extraRequestMethod;

    /**
     * @ORM\Column(name="extra_requestURI")  
     */
    private $extraRequestURI;

    /**
     * @ORM\Column(name="extra_requestParams")  
     */
    private $extraRequestParams;

    public function getInterneId() {
        return $this->interneId;
    }

    public function setInterneId($interneId) {
        $this->interneId = $interneId;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function getPriority() {
        return $this->priority;
    }

    public function getPriorityName() {
        return $this->priorityName;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getExtraRequestId() {
        return $this->extraRequestId;
    }

    public function getExtraRequestMethod() {
        return $this->extraRequestMethod;
    }

    public function getExtraRequestURI() {
        return $this->extraRequestURI;
    }

    public function getExtraRequestParams() {
        return $this->extraRequestParams;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }

    public function setPriority($priority) {
        $this->priority = $priority;
    }

    public function setPriorityName($priorityName) {
        $this->priorityName = $priorityName;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function setExtraRequestId($extraRequestId) {
        $this->extraRequestId = $extraRequestId;
    }

    public function setExtraRequestMethod($extraRequestMethod) {
        $this->extraRequestMethod = $extraRequestMethod;
    }

    public function setExtraRequestURI($extraRequestURI) {
        $this->extraRequestURI = $extraRequestURI;
    }

    public function setExtraRequestParams($extraRequestParams) {
        $this->extraRequestParams = $extraRequestParams;
    }
    public function getExtraClassMethod() {
        return $this->extraClassMethod;
    }

    public function setExtraClassMethod($extraClassMethod) {
        $this->extraClassMethod = $extraClassMethod;
    }


}
