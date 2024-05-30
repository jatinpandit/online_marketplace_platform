<?php 

class Sales_Block_Admin_Shipping_Form extends Core_Block_Template{
    
    public function __construct(){
        $this->setTemplate('sales/admin/shipping/form.phtml');
    }

    public function getShippingData()
    {
        return Mage::getModel('sales/shipping')->load($this->getRequest()->getParams('id',0));
    }
}