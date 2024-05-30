<?php

class Page_Block_Head extends Core_Block_Template{
    
    protected $_js = [];
    protected $_css = [];

    public function __construct(){
        $this->setTemplate('page/Head.phtml');

        $this->addJs('jquery-3.7.1.js');
   }


    public function addJs($file){
        $this->_js[] = $file;
        return $this;
    }
    public function addCss($file){
        $this->_css[] = $file;
        return $this;
    }
    public function getJs(){
        return $this->_js;
    }
    public function getCss(){
        return $this->_css;
    }

}