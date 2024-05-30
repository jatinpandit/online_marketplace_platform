<?php 

class Import_Block_Admin_List extends Core_Block_Template{

    
    public function __construct(){
        $this->setTemplate('import/admin/List.phtml');
    }

    public function getCsvData(){
        return Mage::getModel('import/importCsv')->getCollection()
            ->getData();
    }
}