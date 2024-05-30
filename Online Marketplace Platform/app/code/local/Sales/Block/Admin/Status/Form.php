<?php 

class Sales_Block_Admin_Status_Form extends Core_Block_Template{
    
    public function __construct(){
        $this->setTemplate('sales/admin/status/form.phtml');
    }

    public function getStatusData()
    {
        return Mage::getModel('sales/status')->load($this->getRequest()->getParams('id',0));
    }
}