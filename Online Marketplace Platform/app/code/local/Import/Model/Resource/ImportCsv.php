<?php

class Import_Model_Resource_ImportCsv extends Core_Model_Resource_Abstract{

    public function __construct(){
        $this->init("import_csv","csv_id");
    }
}