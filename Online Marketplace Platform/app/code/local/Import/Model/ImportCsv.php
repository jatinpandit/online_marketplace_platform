<?php

class Import_Model_ImportCsv extends Core_Model_Abstract{
    
    public function init(){
        $this->_resourceClass = "Import_Model_Resource_ImportCsv";
        $this->_collectionClass = "Import_Model_Resource_Collection_ImportCsv";
        $this->_modelClass = "import/importCsv";
    }
}