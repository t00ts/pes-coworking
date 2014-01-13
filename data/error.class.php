<?php

  class APIError {
  
    private $_code;
    private $_message;
    
    public function __construct ($code, $message) {
      empty($code) or $code == "" ? $this->_code = "0" : $this->_code = $code;
      $this->_message = $message;
    }

    public function getMessage () {
      return $this->_message;
    }
    
    public function toXML() {
      $xml = "<error code=\"". $this->_code ."\">";
      $xml.= "<description>". $this->_message ."</description>";
      $xml.= "</error>";
      return $xml;
    }

  }

?>
