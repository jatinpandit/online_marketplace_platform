<?php

class Core_Block_Abstract{

    public $template;
    public $data = [];

    public function setTemplate($template) {
        $this->template = $template;
        return $this;
    }

    public function getTemplate() {
        return $this->template;
    }

    public function __get($key) {
      
    }

    public function __unset($key) {
     
    }

    public function __set($key, $value) {
        
    }

    public function addData($key, $value) {
        $this->data[$key] = $value;
    }

    public function getData($key = null) {
        if ($key === null) {
            return $this->data;
        } elseif (isset($this->data[$key])) {
            return $this->data[$key];
        }
        return null;
    }

    public function setData($data) {
        if (is_array($data)) {
            $this->data = array_merge($this->data, $data);
        }
        return $this;
    }


    public function getUrl($path){
        return Mage::getBaseDir($path);
    }

    public function getRequest() {
        
    }

    public function render() { 
        include(Mage::getBaseDir('app') . '/design/frontend/template/' . $this->getTemplate());
    }
}