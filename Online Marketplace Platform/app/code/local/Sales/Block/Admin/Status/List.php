<?php

class Sales_Block_Admin_Status_List extends Core_Block_Template{

    public function __construct(){
        $this->setTemplate('sales/admin/status/list.phtml');
    }
    
    public function getStatusData(){
        return Mage::getModel('sales/status')->getCollection();
    }
}